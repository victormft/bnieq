<?php

class PressController extends Controller
{
	
	/**
	 * Lists all models.
	 */
	public function actionIndex($startupname, $offset)
	{
		if(Yii::app()->user->isGuest){
            $user = Yii::app()->getComponent('user');
            $user->setFlash(
                'error',
                '<strong>Ops!</strong> Você precisa estar conectado para acessar essa área.'
            );
            $this->redirect(Yii::app()->controller->module->loginUrl);
        }
	
		$model=Startup::model()->find('startupname=:s_name',array(':s_name'=>$startupname));
		
		$qry = new CDbCriteria( array(
			'condition' => "startup_id=:param",
			'order' => "time DESC",
			'params'    => array(':param' => $model->id),  
		) );

		$query = Press::model()->findAll($qry); 
		
		$html='';
		
		foreach ($query as $k => $q)
		{
			if($offset <= $k && $k < $offset+2)
			{       
				/* manipulate url */ 
				$url=preg_replace('/http:\/\//', '', $q->url);
				$url=preg_replace('/https:\/\//', '', $url);
				if(strpos($url, '/'))
					$url=strstr($url, '/', true);
						
				$html .= '		
					<div style="overflow: auto; padding:0 10px 0 10px; margin-bottom:40px;">
						<div class="press-item">
							<div class="press-text" style="overflow:auto;">
								<div class="press-date" style="float:left;">'. date('d/m/y', strtotime(CHtml::encode($q->time))) . '</div>
								<div class="press-right-text" style="float:left; margin-left: 20px; width:400px;">
									<div class="press-url" style="font-weight:bold; font-size: 16px; color:#ccc;">'. CHtml::encode($url) .'</div>
									<div class="press-title">'. CHtml::link(CHtml::encode($q->title), CHtml::encode($q->url), array('target'=>'_blank')) . '</div>
									<div class="press-description">'. CHtml::encode($q->description) . '</div>
								</div>
							</div>
						</div>
					</div>
						';
			}
		}
		
		$new_offset=$offset+2;
		
		if($new_offset < count($query))
			$html .= '<div class="more-press" data-offset='.$new_offset.' style="text-align:center;"><a href="javascript:void(0)">More</a></div>';	

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
