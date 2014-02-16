<?php

class StartupCommentController extends Controller
{
	
	public function actionIndex($startupname, $offset)
	{
	
		$model=Startup::model()->find('startupname=:s_name',array(':s_name'=>$startupname));
		
		$qry = new CDbCriteria( array(
			'condition' => "startup_id=:param",
			'order' => "date DESC",
			'params'    => array(':param' => $model->id),  
		) );

		$query = StartupComment::model()->findAll($qry); 

		$html='';
		
		foreach ($query as $k => $q)
		{
			if($offset <= $k && $k < $offset+2)
			{       
				$user = User::model()->findbypk($q->user_id);
				
				if(Yii::app()->user->id==$q->user_id || Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
					$condition=true;
				else
					$condition=false;
						
				$html .= '		
				<div class="comment-wrap" style="position:relative;">	
					<div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->date))).'</div>
						<div style="overflow: auto; padding:0 10px 0 10px;">
							<div class="team-item">
				';
				
				if($condition)
				{
				
					$html .= '	
									<div class="notif-image" data-id="' . $q->id . '" style="background-image:url(http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$user->profile->logo->name.'); background-size:cover; background-position: 50% 50%;"></div>
					';

				}
				
				else
				{
					$html .= '	
									<div class="notif-image" style="background-image:url(http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$user->profile->logo->name.'); background-size:cover; background-position: 50% 50%;"></div>
					';
				}
				
				$html .= '	
								<div class="team-text" style="float:left;">
									<div class="team-resume"><b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) .'</b> comentou em '. CHtml::link($model->name, array('/'.$model->startupname)) .'</div>
									<div class="team-comment" style="width:300px;">'. CHtml::encode($q->text) .'</div>
								</div>
							</div>
						</div>
				';
				
				if($condition)
				{
					$html .= '
						<div class="comment-delete"><i class="icon-remove-sign"></i></div>
					';
				}
				
				$html .= '	
					<div class="spacing-1"></div>
				</div>
				
				';
			}
		}
		
		$new_offset=$offset+2;
		
		if($new_offset < count($query))
			$html .= '<div class="more-comment" data-offset='.$new_offset.' style="text-align:center;"><a href="javascript:void(0)">More</a></div>';	

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
