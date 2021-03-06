<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        //um pra cada listing
		$model=new Startup('search');
        $model2=new Startup('search');
        $model3=new Startup('search');
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index',array(
                'dataProvider'=>$model,
                'popProvider'=>$model2,
                'recProvider'=>$model3,
            ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionAutoTest()
	{        
		if(!empty($_GET['term']))
		{
			$param = addcslashes($_GET['term'], '%_'); // escape LIKE's special characters
			$qry = new CDbCriteria( array(
				'condition' => "user_id<>1 AND CONCAT(firstname, ' ' , lastname) LIKE :param",         // no quotes around :match
				'params'    => array(':param' => "%$param%"),  // Aha! Wildcards go here
				'limit'=> 5
			) );
			
			$query = Profile::model()->findAll($qry);     // works!
			
			//!!!!!!!!!!!! for startups
			
			$qry_s = new CDbCriteria( array(
				'condition' => "name LIKE :param AND published=1",         // no quotes around :match
				'params'    => array(':param' => "%$param%"),  // Aha! Wildcards go here
				'limit'=> 5
			) );
			
			$query_s = Startup::model()->findAll($qry_s);     // works!
			
			//!!!!!!!!!!!! end for startups
			
		}
		else
		{
			$query = null;
			$query_s = null;
		}
		
		
		$list = array();        
		foreach($query as $q)
		{
			$data['value'] = $q->user_id;
			
			if(isset($q->user->roles) && isset($q->city))
				$data['description'] = $q->user->roles[0]->name .' · '. $q->city->nome;
			else
				$data['description'] = '';
				
			$data['label'] = $q->firstname .' '. $q->lastname;
			$data['image'] = $q->logo->name;
			$data['uname'] = $q->user->username;
			

			$list['myData'][] = $data;
			unset($data);
		}
		
		foreach($query_s as $q)
		{
			$data['value'] = $q->id;		

			$data['description'] = 'Company';
				
			$data['label'] = $q->name;
			$data['image'] = $q->logo0->name;
			$data['uname'] = $q->startupname;

			$list['myData'][] = $data;
			unset($data);
		}
		
		if(!empty($query) || !empty($query_s))
			echo json_encode($list);
		
		else 
			throw new CHttpException(404,UserModule::t('It was not possible to resolve the request.'));
			
	}
    
    public function actionGetNotifications()
	{       
		if(1/*have notifications*/)
		{
			$qry = new CDbCriteria( array(
				'condition' => "user_id LIKE :param",
                'order' => "time DESC",
				'params'    => array(':param' => Yii::app()->user->id),  
				'limit'=> 6
			) );
			
			$query = Notification::model()->findAll($qry);    
			
		}
		else
		{
			/* escrever mensagem de vazio */
		}
        
		$list = array();   
        $html='';
		foreach($query as $q)
		{
            $q->seen = 1;
            $q->save();
            
            $source = User::model()->findbypk($q->source_id);
            switch ($q->notification_type) 
            {
                case Notification::FOLLOW_USER :
                    $html .= '		
                    <a href="'. Yii::app()->request->baseUrl .'/' . $source->username . '"> 
                    <div style="overflow: auto; padding:0 10px 0 10px">
                        <div class="team-item">
                            <div class="notif-image" style="background-image:url(http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$source->profile->logo->name.'); background-size:cover; background-position: 50% 50%;"></div>
                            <div class="team-text">
                                <div class="team-resume"><b>'. $source->getFullName() . '</b> '. UserModule::t('followed you.') . '</div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <li class="divider"></li>
                    ';
                    break;
                case Notification::ASK_MEMBERSHIP_STARTUP :
                    $startup = Startup::model()->findbypk($q->target_id);
                    $html .= '		
                    <a href="'. Yii::app()->request->baseUrl .'/' . $startup->startupname . '"> 
                    <div style="overflow: auto; padding:0 10px 0 10px">
                        <div class="team-item">
                            <div class="notif-image" style="background-image:url(http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$source->profile->logo->name.'); background-size:cover; background-position: 50% 50%;"></div>
                            <div class="team-text">
                                <div class="team-resume"><b>'. $source->getFullName() . '</b> '. UserModule::t('asked for membership in') . ' <b>' . $startup->name . '</b>.</div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <li class="divider"></li>
                    ';
                    break;
                
                case Notification::ADDED_TO_STARTUP :
                    $startup = Startup::model()->findbypk($q->target_id);
                    $html .= '		
                    <a href="'. Yii::app()->request->baseUrl .'/' . $startup->startupname . '"> 
                    <div style="overflow: auto; padding:0 10px 0 10px">
                        <div class="team-item">
                            <div class="notif-image" style="background-image:url(http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$source->profile->logo->name.'); background-size:cover; background-position: 50% 50%;"></div>
                            <div class="team-text">
                                <div class="team-resume"><b>'. $source->getFullName() . '</b> '. UserModule::t('added you to') . ' <b>' . $startup->name . '</b>.</div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <li class="divider"></li>
                    ';
                    break;
            }
		}
		
        $c=Notification::model()->getCountUnreaded(Yii::app()->user->getId());
        echo CJSON::encode(array(
            'res'=>$html,
            'c'=>$c>0 ? $c : ''
        ));
        exit;
			
	}
}