<?php

class StartupUpdateController extends Controller
{
	
	public function actionIndex($startupname, $offset)
	{
	
		$model=Startup::model()->find('startupname=:s_name',array(':s_name'=>$startupname));
		
		$qry = new CDbCriteria( array(
			'condition' => "startup_id=:param",
			'order' => "date DESC",
			'params'    => array(':param' => $model->id),  
		) );

		$query = StartupUpdate::model()->findAll($qry); 

		$html='';
		
		foreach ($query as $k => $q)
		{
			if($offset <= $k && $k < $offset+2)
			{       
						
				$html .= '		
					<div class="update-item" style="margin-bottom: 30px;">
						<div class="update-text" style="margin-left:50px; width:80%;">
							<div class="update-title" style="margin-bottom: 20px; display:inline-block; width:300px;"><span data-id="'. $q->id .'"><b>'. CHtml::encode($q->title) .'</b></span></div>
							<div class="update-date" style="float:right;">'. date('d/m/y', strtotime(CHtml::encode($q->date))) . '</div>
							<div class="update-description">'. CHtml::encode($q->description) .'</div></td>
						</div>
					</div>
					<div style="border-top:1px dashed #aaa; margin-bottom:30px;"></div>
						';
			}
		}
		
		$new_offset=$offset+2;
		
		if($new_offset < count($query))
			$html .= '<div class="more-update" data-offset='.$new_offset.' style="text-align:center;"><a href="javascript:void(0)">More</a></div>';	

		else 
			$html .= '<div style="text-align:center;">No More</div>';
		
		echo CJSON::encode(array(
            'res'=>$html 
        ));
        exit;
				
		/*$this->render('index',array(
			'model'=>Startup::model()->find('startupname=:s_name',array(':s_name'=>$startupname));,
		));*/
	}

}
