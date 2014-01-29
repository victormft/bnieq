<?php

class ActivityStartupController extends Controller
{
	
	/**
	 * Lists all models.
	 */
	public function actionIndex($startupname, $offset)
	{
		if(Yii::app()->user->isGuest){
            
			$html='
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
					<a class="btn btn-primary" href="'. Yii::app()->request->baseUrl .'/user/login">Login</a>
				</p>
			';
			echo CJSON::encode(array(
            'res'=>$html 
			));
			exit;
        }
	
		$model=Startup::model()->find('startupname=:s_name',array(':s_name'=>$startupname));
		
		$qry = new CDbCriteria( array(
			'condition' => "startup_id=:param",
			'order' => "time DESC",
			'params'    => array(':param' => $model->id),  
		) );

		$query = ActivityStartup::model()->findAll($qry); 
		
		$html='';
		
		foreach ($query as $k => $q)
		{
			if($offset <= $k && $k < $offset+2)
			{
				if(isset($q->user_id)){
					$user = User::model()->findbypk($q->user_id);
				}
				
				switch ($q->activity_type) 
				{        
					case ActivityStartup::FOLLOW_STARTUP :
						$html .= '		
						<div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->time))).'</div>
						<div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
							<div class="team-item">
								<div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $user->profile->logo->name .'" /></div>
								<div class="team-text" style="float:left;>
									<div class="team-resume"><b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) . '</b> '. UserModule::t('followed you.') . '</div>
								</div>
							</div>
						</div>
						<div class="spacing-1"></div>
						';
					break;
						
					case ActivityStartup::ADD_TRACTION :
						$html .= '		
						<div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->time))).'</div>
						<div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
							<div class="team-item">
								<div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $q->startup->logo0->name .'" /></div>
								<div class="team-text" style="float:left;>
									<div class="team-resume"><b>'. CHtml::link($q->startup->name, array('/'.$q->startup->startupname)) . '</b> adicionou novo <b>'. CHtml::link('Traction', array('/'.$q->startup->startupname . '?r='.rand(0,99999).'#traction')) . '.</b></div>
								</div>
							</div>
						</div>
						<div class="spacing-1"></div>
						';
					break;
					
					case ActivityStartup::ADD_PRESS :
						$html .= '		
						<div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->time))).'</div>
						<div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
							<div class="team-item">
								<div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $q->startup->logo0->name .'" /></div>
								<div class="team-text" style="float:left;>
									<div class="team-resume"><b>'. CHtml::link($q->startup->name, array('/'.$q->startup->startupname)) . '</b> adicionou novo <b><span class="press-link">'. CHtml::link('Press', array('/'.$q->startup->startupname.'#press')) . '.</span></b></div>
								</div>
							</div>
						</div>
						<div class="spacing-1"></div>
						';
					break;
					
					case ActivityStartup::ADD_MEMBER :
						$html .= '		
						<div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->time))).'</div>
						<div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
							<div class="team-item">
								<div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $q->startup->logo0->name .'" /></div>
								<div class="team-text" style="float:left;>
									<div class="team-resume"><b>'. CHtml::link($q->startup->name, array('/'.$q->startup->startupname)) . '</b> adicionou o membro <b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) . '</b> </div>
								</div>
							</div>
						</div>
						<div class="spacing-1"></div>
						';
					break;
					
					case ActivityStartup::ADD_UPDATE :
						$html .= '		
						<div style="float:left; margin-right:30px; line-height:45px;">'.date('d/m/y', strtotime(CHtml::encode($q->time))).'</div>
						<div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
							<div class="team-item">
								<div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $q->startup->logo0->name .'" /></div>
								<div class="team-text" style="float:left;>
									<div class="team-resume"><b>'. CHtml::link($q->startup->name, array('/'.$q->startup->startupname)) . '</b> adicionou novo <b><span class="update-link">'. CHtml::link('Update', array('/'.$q->startup->startupname.'#update')) . '.</span></b></div>
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
