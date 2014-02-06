<?php

class ActivityUserController extends Controller
{

	/**
	 * Lists all models.
	 */
	public function actionIndex($username, $offset, $last_date=0)
	{
        if(Yii::app()->user->isGuest)
        {
            $user = Yii::app()->getComponent('user');
            $user->setFlash(
                'error',
                '<strong>Ops!</strong> Você precisa estar conectado para acessar essa área.'
            );
            $this->redirect(Yii::app()->controller->module->loginUrl);
        }
	
		$model=User::model()->find('username=:u_name',array(':u_name'=>$username));
		
		$qry = new CDbCriteria( array(
			'condition' => "user_id LIKE :param",
			'order' => "time DESC",
			'params'    => array(':param' => $model->id),  
		) );

		$query = ActivityUser::model()->findAll($qry); 
		
		$html='';
        
        
		foreach ($query as $k => $q)
		{
            if($offset <= $k && $k < $offset+5)
            {
                
                $user = User::model()->findbypk($model->id);
                switch ($q->type) 
                {        
                    case ActivityUser::FOLLOW_USER :   
                        if(date('d/m/y', strtotime($q->time)) != $last_date)
                        {

                            if(isset($together) ? !in_array($k, $together) : 1)
                            {
                                for($i=1, $together=array() ; isset($query[$k+$i]) ? date('d/m/y', strtotime($query[$k+$i]['time'])) == date('d/m/y', strtotime($query[$k]['time'])) : 0 ; $i++) //$c conta os follows na mesma data
                                {
                                    if($query[$k+$i]['type'] == ActivityUser::FOLLOW_USER)
                                    {
                                        $together=array_merge($together,array($k+$i)); 
                                        $offset++;
                                    }
                                                    
                                }
                                $names = '';
                                if(count($together)>0)
                                {
                                    $names .= ' '.CHtml::link(User::model()->findbypk($query[$k]['target_id'])->getFullName(), array('/'.User::model()->findbypk($query[$k]['target_id'])->username)).',';

                                    foreach($together as $tind => $qind)
                                    {
                                        if($tind < count($together)-1)
                                            $names .= ' '.CHtml::link(User::model()->findbypk($query[$qind]['target_id'])->getFullName(), array('/'.User::model()->findbypk($query[$qind]['target_id'])->username)).',';
                                        else
                                        {
                                            $names = substr($names, 0, -1); //tira ultima virgula
                                            $names .= ' and '.CHtml::link(User::model()->findbypk($query[$qind]['target_id'])->getFullName(), array('/'.User::model()->findbypk($query[$qind]['target_id'])->username)).'.';                          
                                        }
                                    }
                                }
                                else
                                {
                                    $names = CHtml::link(User::model()->findbypk($q->target_id)->getFullName(), array('/'.User::model()->findbypk($q->target_id)->username));
                                }

                                $html .= '		
                                <div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->time))).'</div>
                                <div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
                                    <div class="team-item">
                                        <div class="notif-image" ><img src="http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$user->profile->logo->name .'" /></div>
                                        <div class="team-text" style="float:left; max-width:370px;">
                                            <div class="team-resume" style="line-height:20px;"><b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) . '</b> '. UserModule::t('followed') . ' ' . $names . '</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="spacing-1"></div>
                                ';
                            }
                        }
                        break;

                    case ActivityUser::FOLLOW_STARTUP :
                        $startup = Startup::model()->findbypk($q->target_id);
                        $html .= '
                        <div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->time))).'</div>
                        <div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
                            <div class="team-item">
                                <div class="notif-image"><img src="http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$user->profile->logo->name .'" /></div>
                                <div class="team-text" style="float:left;">
                                    <div class="team-resume"><b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) . '</b> seguiu a startup '. CHtml::link($startup->name, array('/'.$startup->startupname)) .'</div>
                                </div>
                            </div>
                        </div>
                        <div class="spacing-1"></div>
                        ';
                        break;

                    case ActivityUser::FOUNDED_STARTUP :
                        $startup = Startup::model()->findbypk($q->target_id);
                        $html .= '		
                        <div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->time))).'</div>
                        <div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
                            <div class="team-item">
                                <div class="notif-image"><img src="http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$user->profile->logo->name .'" /></div>
                                <div class="team-text" style="float:left;">
                                    <div class="team-resume"><b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) . '</b> publicou a startup '. CHtml::link($startup->name, array('/'.$startup->startupname)) . '</div>
                                </div>
                            </div>
                        </div>
                        <div class="spacing-1"></div>
                        ';
                        break;

                    case ActivityUser::IS_IN_STARTUP :
                        $startup = Startup::model()->findbypk($q->target_id);
                        $html .= '	
                        <div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->time))).'</div>
                        <div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
                            <div class="team-item">
                                <div class="notif-image"><img src="http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$user->profile->logo->name .'" /></div>
                                <div class="team-text" style="float:left; max-width:370px;">
                                    <div class="team-resume"><b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) . '</b> entrou para a startup '. CHtml::link($startup->name, array('/'.$startup->startupname)) . '</div>
                                </div>
                            </div>
                        </div>
                        <div class="spacing-1"></div>
                        ';
                        break;
                }
                $last_date=date('d/m/y', strtotime($q->time));
            }
            
		}
		
		$new_offset=$offset+5;
        
		
		if($new_offset < count($query))
            $html .= '<div class="more-activities" data-offset='.$new_offset.' data-last_date="'.$last_date.'" style="text-align:center;"><a href="javascript:void(0)">More</a></div>';	
            
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
