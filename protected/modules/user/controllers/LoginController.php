<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

    public $attempts = 3; // allowed 3 attempts
    public $counter;
    
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
            $login = $this->captchaRequired()? new UserLogin('captchaRequired') : new UserLogin;
            //$login=new UserLogin;
            $model = new RegistrationForm;
            $profile=new Profile;
            $profile->regMode = true;
            
            // ajax validator
            if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
            {
                echo UActiveForm::validate(array($model,$profile));
                Yii::app()->end();
            }
            
            if (Yii::app()->user->id) {
                $this->redirect(Yii::app()->controller->module->profileUrl);
            } else {
                if(isset($_POST['RegistrationForm'])) {
                    $model->attributes=$_POST['RegistrationForm'];
                    $profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
                    if($model->validate()&&$profile->validate())
                    {
                        $soucePassword = $model->password;
                        $model->activkey=UserModule::encrypting(microtime().$model->password);
                        $model->password=UserModule::encrypting($model->password);
                        $model->verifyPassword=UserModule::encrypting($model->verifyPassword);
                        $model->superuser=0;
                        $model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
                        $model->setCreateTime(time());                       

                        if ($model->save()) {         
                            
                            $profile->user_id=$model->id;

                            //profile pic
                            $profile->profile_picture = 2;
                            
                            //save the roles in registration
                            if(isset($_POST['RegistrationForm']['role'])) 
                            {
                                switch ($_POST['RegistrationForm']['role']){
                                    case 1: 
                                        $vals = Role::model()->find('role_id=6');
                                        $model->roles = $vals;
                                        $model->saveWithRelated(array('roles')); 
                                        break;
                                    case 2:
                                        $vals = Role::model()->find('role_id=5');
                                        $model->roles = $vals;
                                        $model->saveWithRelated(array('roles')); 
                                        break;
                                    case 3:
                                        $vals[] = Role::model()->find('role_id=5');
                                        $vals[] = Role::model()->find('role_id=6');
                                        $model->roles = $vals;
                                        $model->saveWithRelated(array('roles')); 
                                        break;                                        
                                }                                     
                            }

                            $profile->save();
                            
                            //subscribe to MailChimp
                            if($model->newsletter == true)
                            {
                                $MailChimp = new MailChimp('62ef20e8abc7616367e9a4fb08d4cf23-us3');
                                $MailChimp->call('lists/subscribe', array(
                                    'id'                => 'b6e780f08c',
                                    'email'             => array('email'=>$model->email),
                                    'merge_vars'        => array('NAME'=>$model->getFullName()),
                                    'double_optin'      => false,
                                    'update_existing'   => true,
                                    'replace_interests' => false,
                                    'send_welcome'      => false,
                                ));
                            }
                            
                            if (Yii::app()->controller->module->sendActivationMail) {
                                $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
                                UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
                            }

                            if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
                                   $identity=new UserIdentity($model->username,$soucePassword);
                                   $identity->authenticate();
                                   Yii::app()->user->login($identity,0);
                                   $this->redirect(Yii::app()->controller->module->returnUrl);
                            } else {
                                if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
                                    Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
                                } elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
                                    Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
                                } elseif(Yii::app()->controller->module->loginNotActiv) {
                                    Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
                                } else {
                                    Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
                                }
                                $this->refresh();
                            }
                        }
                    } else $profile->validate();
                }
                //$this->render('/user/registration',array('model'=>$model,'profile'=>$profile));
            }

			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$login->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($login->validate()) {
					$this->lastViset();
					if (Yii::app()->user->returnUrl=='/index.php')
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
                else
                {
                    $this->counter = Yii::app()->session->itemAt('captchaRequired') + 1;
                    Yii::app()->session->add('captchaRequired',$this->counter);
                }
			}
			// display the login form
			$this->render('/user/login',array('login'=>$login, 'model'=>$model,'profile'=>$profile));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
    
    private function captchaRequired()
    {           
        return Yii::app()->session->itemAt('captchaRequired') >= $this->attempts;
    }
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}
    
    public function actions()
    {   
      return array(
        'oauth' => array(
            'class'=>'ext.hoauth.HOAuthAction',
        ),
        'captcha'=>array(
            'class'=>'CCaptchaAction',
            'backColor'=>0xFFFFFF,
        ),
      );
    }
    
}