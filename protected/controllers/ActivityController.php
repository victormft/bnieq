<?php

class ActivityController extends Controller
{

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        if(Yii::app()->user->isGuest){
            $user = Yii::app()->getComponent('user');
            $user->setFlash(
                'error',
                '<strong>Ops!</strong> Você precisa estar conectado para acessar essa área.'
            );
            $this->redirect(Yii::app()->controller->module->loginUrl);
        }
			
		$qryU = new CDbCriteria( array(
			'condition' => "user_id IN (SELECT followed_id FROM user_follow WHERE follower_id=:uId) AND DAY(time) >= DAY(NOW())-30",
			'order' => "time DESC",
			'params'    => array(':uId' => Yii::app()->user->id),  
		) );

		$queryU = ActivityUser::model()->findAll($qryU); 
		
        $qryS = new CDbCriteria( array(
			'condition' => "startup_id IN (SELECT startup_id FROM startup_follow WHERE user_id=:uId) AND DAY(time) >= DAY(NOW())-30",
			'order' => "time DESC",
			'params'    => array(':uId' => Yii::app()->user->id),  
		) );

		$queryS = ActivityStartup::model()->findAll($qryS); 
        
		$html='';
		
		foreach ($queryU as $q)
		{
            $user = User::model()->findbypk($q->user_id);
            switch ($q->type) 
            {        
                case ActivityUser::FOLLOW_USER :
                    $target = User::model()->findbypk($q->target_id);
                    $html .= '		
                    <div class="activity-wrap">
                        <div class="team-item">
                            <div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $user->profile->logo->name .'" /></div>
                            <div class="team-text">
                                    <div class="team-resume"><b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) . '</b> '. UserModule::t('followed') . ' ' . CHtml::link($target->getFullName(), array('/'.$target->username)) . '</div>
                            </div>
                        </div>
                    </div>
                    <div class="spacing-1"></div>
                    ';
                    break;

                case ActivityUser::FOLLOW_STARTUP :
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
		
		/*echo CJSON::encode(array(
            'res'=>$html 
        ));
        exit;*/
				
		$this->render('index',array(
			'html'=>$html,
            'active'=>'index',
		));
	}

	
}
