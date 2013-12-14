<?php

class ActivityStartupController extends Controller
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
			'condition' => "startup_id LIKE :param",
			'order' => "time DESC",
			'params'    => array(':param' => $model->id),  
		) );

		$query = ActivityStartup::model()->findAll($qry); 
		
		$html='';
		
		foreach ($query as $k => $q)
		{
			if($offset <= $k && $k < $offset+2)
			{
			
				$user = User::model()->findbypk($q->user_id);
				switch ($q->activity_type) 
				{        
					case ActivityStartup::FOLLOW_STARTUP :
						$html .= '		
						<div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
							<div class="team-item">
								<div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $user->profile->logo->name .'" /></div>
								<div class="team-text">
									<div class="team-resume"><b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) . '</b> '. UserModule::t('followed you.') . '</div>
								</div>
							</div>
						</div>
						<div class="spacing-1"></div>
						';
						break;
				   
				}
			}
		}
		
		$new_offset=$offset+2;
		
		if($new_offset < count($query))
			$html .= '<div class="more-activities" data-offset='.$new_offset.' style="text-align:center;"><a href="javascript:void(0)">More</a></div>';	

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
