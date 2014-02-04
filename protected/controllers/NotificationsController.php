<?php

class NotificationsController extends Controller
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
        

        $qry = new CDbCriteria( array(
            'condition' => "user_id LIKE :param AND DAY(time) >= DAY(NOW())-7",
            'order' => "time DESC",
            'params'    => array(':param' => Yii::app()->user->id),  
            'limit'=> 40
        ) );

        $query = Notification::model()->findAll($qry); 
         
        $html='';
        foreach ($query as $q)
        {
            $q->seen = 1;
            $q->save();

            $source = User::model()->findbypk($q->source_id);
            switch ($q->notification_type) 
            {        
                case Notification::FOLLOW_USER :
                    $html .= '		
                    <div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
                        <div class="team-item">
                            <div class="notif-image"><img src="http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$source->profile->logo->name .'" /></div>
                            <div class="team-text">
                                <div class="team-resume"><b>'. CHtml::link($source->getFullName(), array('/'.$source->username)) . '</b> '. UserModule::t('followed you.') . '</div>
                            </div>
                        </div>
                    </div>
                    <div class="spacing-1"></div>
                    ';
                    break;
                case Notification::ASK_MEMBERSHIP_STARTUP :
                    $startup = Startup::model()->findbypk($q->target_id);
                    $html .= '		
                    <div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
                        <div class="team-item">
                            <div class="notif-image"><img src="http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$source->profile->logo->name .'" /></div>
                            <div class="team-text">
                                <div class="team-resume"><b>'. CHtml::link($source->getFullName(), array('/'.$source->username)) . '</b> '. UserModule::t('asked for membership in') . ' <b>' . CHtml::link($startup->name, array('/'.$startup->startupname)) . '</b>.</div>
                            </div>
                        </div>
                    </div>
                    <div class="spacing-1"></div>
                    ';
                    break;

                case Notification::ADDED_TO_STARTUP :
                    $startup = Startup::model()->findbypk($q->target_id);
                    $html .= '		
                    <div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
                        <div class="team-item">
                            <div class="notif-image"><img src="http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$source->profile->logo->name .'" /></div>
                            <div class="team-text">
                                <div class="team-resume"><b>'. CHtml::link($source->getFullName(), array('/'.$source->username)) . '</b> '. UserModule::t('added you to') . ' <b>' . CHtml::link($startup->name, array('/'.$startup->startupname)) . '</b>.</div>
                            </div>
                        </div>
                    </div>
                    <div class="spacing-1"></div>
                    ';
                    break;
            }
        }
                
		$this->render('index',array(
            'html'=>$html,
        ));
                 
	}

}