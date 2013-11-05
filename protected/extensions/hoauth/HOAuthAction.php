<?php
/**
 * HOAuthAction - this the main class in hoauth extension.
 * 
 * @uses CAction
 * @version 1.2.4
 * @copyright Copyright &copy; 2013 Sviatoslav Danylenko
 * @author Sviatoslav Danylenko <dev@udf.su> 
 * @license MIT ({@link http://opensource.org/licenses/MIT})
 * @link https://github.com/SleepWalker/hoauth
 */

/**
 * HOAuthAction provides simple integration with social network authorization lib Hybridauth in Yii.
 *
 * HOAuthAction requires, that your user model implements findByEmail() method, that should return user model by its email.
 *
 * Avaible social networks: 
 *    OpenID, Google, Facebook, Twitter, Yahoo, MySpace, Windows Live, LinkedIn, Foursquare, AOL
 * Additional social networks can be found at: {@link http://hybridauth.sourceforge.net/download.html}
 *
 * Social Auth widget:
 *    <?php $this->widget('ext.hoauth.HOAuthWidget', array(
 *      'controllerId' => 'site', // id of controller where is your oauth action (default: site)
 *    )); ?>
 * uses a little modified Zocial CSS3 buttons: {@link https://github.com/samcollins/css-social-buttons/}
 */


Yii::setPathOfAlias('hoauth', dirname(__FILE__));

class HOAuthAction extends CAction
{
	/**
	 * @var boolean $enabled defines whether the ouath functionality is active. Useful for example for CMS, where user can enable or disable oauth functionality in control panel
	 */
	public $enabled = true;

	/**
	 * @var string $model yii alias for user model (or class name, when this model class exists in import path)
	 */
	public $model = 'User';

	/**
	 * @var array $attributes attributes synchronization array (user model attribute => oauth attribute). List of available profile attributes you can see at {@link http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Profile.html "HybridAuth's Documentation"}.
	 *
	 * Additional attributes:
	 *    birthDate - The full date of birthday, eg. 1991-09-03
	 *    genderShort - short representation of gender, eg. 'm', 'f'
	 *
	 * You can also set attributes, that you need to save in model too, eg.:
	 *    'attributes' => array(
	 *      'is_active' => 1,
	 *      'date_joined' => new CDbExpression('NOW()'),
	 *    ),
	 *
	 * @see HOAuthAction::$avaibleAtts
	 */
	public $attributes;

	/**
	 * @var string $scenario scenario name for the $model (optional)
	 */
	public $scenario = 'insert';

	/**
	 * @var string $loginAction name of a local login action
	 */
	public $loginAction = 'actionLogin';

	/**
	 * @var integer $duration how long the script will remember the user
	 */
	public $duration = 2592000; // 30 days

	/**
	 * @var boolean $useYiiUser enables support of Yii user module
	 */
	public static $useYiiUser = false;

	/**
	 * @var boolean $alwaysCheckPass flag to control password checking for the scenario, 
	 *      when when social network returned email of existing local account. If set to
	 *      `false` user will be automatically logged in without confirming account with password
	 */
	public $alwaysCheckPass = false;

	/**
	 * @var string $userIdentityClass UserIdentity class that will be used to log user in.
	 */
	public $userIdentityClass = 'UserIdentity';

	/**
	 * @var string $usernameAttribute you can specify the username attribute, when user must fill it
	 */
	public $usernameAttribute = false;

	/**
	 * @var string $_emailAttribute
	 */
	protected $_emailAttribute = false;

	/**
	 * @var array $avaibleAtts Hybridauth attributes that support by this script (this a list of all available attributes in HybridAuth 2.0.11) + additional attributes (see $attributes)
	 */
	protected $_avaibleAtts = array('identifier', 'profileURL', 'webSiteURL', 'photoURL', 'displayName', 'description', 'firstName', 'lastName', 'gender', 'language', 'age', 'birthDay', 'birthMonth', 'birthYear', 'email', 'emailVerified', 'phone', 'address', 'country', 'region', 'city', 'zip', 'birthDate', 'genderShort');

	public function run()
	{		
		// openId login
		if($this->enabled)
		{
			$path = dirname(__FILE__);
			// checking if we have `yii-user` module (I think that `UWrelBelongsTo` is unique class name from `yii-user`)
			if($this->useYiiUser || file_exists(Yii::getPathOfAlias('application.modules.user.components') . '/UWrelBelongsTo.php'))
			{
				$this->useYiiUser = true;
				// setting up yii-user's user model
				Yii::import('application.modules.user.models.*');
				Yii::import('hoauth.DummyUserIdentity');

				// preparing attributes array for `yii-user` module
				if(!is_array($this->attributes))
					$this->attributes = array();
                
				$this->attributes = CMap::mergeArray($this->attributes, array(
					'email' => 'email',
					'username' => 'displayName',
					'status' => User::STATUS_ACTIVE,
					));

				$this->usernameAttribute = 'username';
				$this->_emailAttribute = 'email';
			}
			else
			{
				Yii::import($this->model, true);
				$this->model = substr($this->model, strrpos($this->model, '.'));

				if(!method_exists($this->model, 'findByEmail'))
					throw new Exception("Model '{$this->model}' must implement the 'findByEmail' method");

				$this->_emailAttribute = array_search('email', $this->attributes);
			}

			if(!isset($this->attributes) || !is_array($this->attributes) || !count($this->attributes))
				throw new CException('You must specify the model attributes for ' . __CLASS__);

			if(!in_array('email', $this->attributes))
				throw new CException("You forgot to bind 'email' field in " . __CLASS__ . "::attributes property.");

			if(isset($_GET['provider']))
			{
				Yii::import('hoauth.models.*');
				$this->oAuth($_GET['provider']);
			}
			else
			{
				require($path.'/hybridauth/index.php');
				Yii::app()->end();
			}
		}

		Yii::app()->controller->{$this->loginAction}();
	}

	/**
	 * Initiates authorization with specified $provider and 
	 * then authenticates the user, when all goes fine
	 * 
	 * @param mixed $provider provider name for HybridAuth
	 * @access protected
	 * @return void
	 */
	protected function oAuth( $provider )
	{
		try{
			// trying to authenticate user via social network
			$oAuth = UserOAuth::model()->authenticate( $provider );
			$userProfile = $oAuth->profile;           

			// If we already have a user logged in, associate the authenticated 
			// provider with the logged-in user
			if(!Yii::app()->user->isGuest) 
			{
				$accessCode = 1;
				$oAuth->bindTo(Yii::app()->user->id);
                $profile = $this->saveProfile(User::model()->findByPk(Yii::app()->user->id), $userProfile, $provider);
                if(!$profile->save())
					throw new Exception("Error, while saving " . get_class($profile) . "	model:\n\n" . var_export($profile->errors, true));
			}
			else 
			{
				$newUser = false;
				if($oAuth->isBond)
				{
					// this social network account is bond to existing local account
					Yii::log("Logged in with existing link with '$provider' provider", CLogger::LEVEL_INFO, 'hoauth.'.__CLASS__);
					if($this->useYiiUser){                        
						$user = User::model()->findByPk($oAuth->user_id);
                        $lastVisit = User::model()->notsafe()->findByPk($oAuth->user_id);
                        $lastVisit->lastvisit = time();
                        $lastVisit->save();
                    }
					else
						$user = call_user_func(array($this->model, 'model'))->findByPk($oAuth->user_id);
				}

				if(!$oAuth->isBond || !$user)
				{
					if(!empty($userProfile->emailVerified))
					{
						// checking whether we already have a user with specified email
						if($this->useYiiUser)
							$user = User::model()->findByAttributes(array('email' => $userProfile->emailVerified));
						else
							$user = call_user_func(array($this->model, 'model'))->findByEmail($userProfile->emailVerified);
					}

					if(!isset($user))
					{
						// registering a new user
						$user = new $this->model($this->scenario); //ainda nao esta definido os campos
						$newUser = true;
					}
                    
					if($this->alwaysCheckPass || $user->isNewRecord)
						if(method_exists($this->controller, 'hoauthProcessUser'))
							$user = $this->controller->hoauthAfterLogin($user, $newUser);
						else
							$user = $this->processUser($user, $userProfile, $provider); //aqui define os campos
				}

				// checking if current user is not banned or anything else
				// $accessCode == 0 - user shouldn't get access
				// $accessCode == 1 - user may login
				// $accessCode == 2 - user may login, but not now (e.g. the email should be verified and activated)
				$accessCode = 1;
				if(method_exists($this->controller, 'hoauthCheckAccess'))
					$accessCode = $this->controller->hoauthCheckAccess($user);
				elseif($this->useYiiUser)
					$accessCode = $this->yiiUserCheckAccess($user);

				if(!$accessCode)
					throw new Exception("Something wrong. You can not log in.");

				if(!$oAuth->bindTo($user->primaryKey))
					throw new Exception("Error, while binding user to provider:\n\n" . var_export($oAuth->errors, true));

				// sign user in
				if($accessCode === 1)
				{
					$identity = $this->useYiiUser
					? new DummyUserIdentity($user->primaryKey, $user->email)
					: new $this->userIdentityClass($user->email, null);

					if(!Yii::app()->user->login($identity,$this->duration))
						throw new Exception("Can't sign in, something wrong with UserIdentity class.");

					// user was successfully logged in
					// firing callback
					if(method_exists($this->controller, 'hoauthAfterLogin'))
						$this->controller->hoauthAfterLogin($user, $newUser);
				}

				if($accessCode === 2)
					Yii::app()->end(); // stopping script to let checkAccess() function render new content
			}

			if($accessCode === 1)
			{
				?>
				<script>
					window.opener.location.reload();
					window.close();
				</script>
				<?php
				Yii::app()->end();
			}
		}
		catch( Exception $e ){
			if(YII_DEBUG)
			{
				$error = "";

				// Display the received error
				switch( $e->getCode() ){ 
					case 0 : $error = "Unspecified error."; throw $e; break;
					case 1 : $error = "Hybriauth configuration error."; break;
					case 2 : $error = "Provider not properly configured."; break;
					case 3 : $error = "Unknown or disabled provider."; break;
					case 4 : $error = "Missing provider application credentials."; break;
					case 5 : $error = "Authentication failed. The user has canceled the authentication or the provider refused the connection."; break;
					case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
					$oAuth->logout(); 
					break;
					case 7 : $error = "User not connected to the provider."; 
					$oAuth->logout(); 
					break;
					case 8 : $error = "Provider does not support this feature.";	break;
				}

				$error .= "\n\n<br /><br /><b>Original error message:</b> " . $e->getMessage(); 
				Yii::log($error, CLogger::LEVEL_INFO, 'hoauth.'.__CLASS__);

				echo $error;
				Yii::app()->end();
			}
		}
		?>
		<script>
			window.close();
		</script>
		<?php
	}
	
	/**
	 * Registers new user, collects username and email if needed
	 *
	 * @param CActiveRecord $user current user model
	 * @param object $userProfile social network's user profile object
	 * @access protected
	 */
	protected function processUser($user, $userProfile, $provider)
	{
		if($this->useYiiUser)
		{
			$profile = new Profile();
			// enabling register mode
			// old versions of yii
			$profile->regMode = true;
			// new version, when regMode is static property
			$prop = new ReflectionProperty('Profile', 'regMode');
			if($prop->isStatic())
				Profile::$regMode = true;
		}

		if($user->isNewRecord)
			$this->populateModel($user, $userProfile); //aqui define os campos

		// trying to fill email and username fields
		// NOTE: we display `username` field in our form only if it is required by the model
		if(!$user->isAttributeRequired($this->usernameAttribute))            			
            $this->usernameAttribute = false;
        
		$form = new HUserInfoForm($user, $this->_emailAttribute, $this->usernameAttribute);

		if(!$form->validateUser())
		{
			$this->controller->render('hoauth.views.form', array(
				'form' => $form,
				));
			Yii::app()->end();
		}

		// updating attributes in $user model (if needed)
		$user = $form->validUserModel;

		// the model won't be new, if user provided email and password of existing account
		if($user->isNewRecord) 
		{
			if(!$user->save())
				throw new Exception("Error, while saving {$this->model} model:\n\n" . var_export($user->errors, true));

			// trying to send activation email
			$this->sendActivationEmail($user);

			if($this->useYiiUser)
			{
                $profile = $this->saveProfile($user, $userProfile, $provider);
              
				if(!$profile->save())
					throw new Exception("Error, while saving " . get_class($profile) . "	model:\n\n" . var_export($profile->errors, true));
			}
		}

		return $user;
	}

	/**
	 * Sends email activation email, when it is needed	
	 * 
	 * @param CActiveRecord $user current user model
	 * @access protected
	 * @return void
	 */
	protected function sendActivationEmail($user)
	{
		if($this->useYiiUser)
		{
			// why not to put this code not in controller, but in the User model of `yii-user` module?
			// for now I can only copy-paste this code from controller...
			if (Yii::app()->getModule('user')->sendActivationMail) 
			{
				$activation_url = Yii::app()->createAbsoluteUrl('/user/activation/activation',array("activkey" => $user->activkey, "email" => $user->email));
				UserModule::sendMail($user->email,UserModule::t("You registered on {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("To activate your account, please go to {activation_url}",array('{activation_url}'=>$activation_url)));
			}
		}
		else
		{
			if(method_exists($user, 'sendActivationEmail'))
				$user->sendActivationEmail();
			elseif(method_exists($user, 'sendActivationMail')) // TODO: delete in future
				$user->sendActivationMail();
		}
	}

	/**
	 * Populates User model with data from social network profile
	 * 
	 * @param CActiveRecord $user users model
	 * @param mixed $profile HybridAuth user profile object
	 * @access protected
	 */
	protected function populateModel($user, $profile)
	{
        
		foreach($this->attributes as $attribute => $pAtt)
		{
			if(in_array($pAtt, $this->_avaibleAtts))
			{
				switch($pAtt)
				{
					case 'genderShort':
					$gender = array('female'=>'f','male'=>'m');
					$att = $gender[$profile->gender];
					break;
					case 'birthDate':
					$att = $profile->birthYear 
					? sprintf("%04d-%02d-%02d", $profile->birthYear, $profile->birthMonth, $profile->birthDay)
					: null;
					break;
					case 'email':
					$att = $profile->emailVerified;
					break;
					default:
					$att = $profile->$pAtt;
				}
				if(!empty($att))
					$user->$attribute = $att;
			}else{
				$user->$attribute = $pAtt;
			}
		}
        
        $username = $profile->firstName.$profile->lastName;
        $username = str_replace(" ", "", $username); // Replaces all spaces with hyphens.
        $username = preg_replace('/[^A-Za-z0-9]/', '', $username);
        $username  = strtolower($username);
        $user->username = $username;
        $user->setCreateTime(time());
	}

	/**
	 * Checks whether the $user can be logged in
	 *
	 * @param CActiveRecord $user current `yii-user` user's model
	 * @param boolean $render flag that enables rendering
	 */
	public function yiiUserCheckAccess($user, $render = true)
	{
		if($user->status==0&&Yii::app()->getModule('user')->loginNotActiv==false)
		{
			$error = UserIdentity::ERROR_STATUS_NOTACTIV;
			$return = 2;
		}
		else if($user->status==-1)
		{
			$error = UserIdentity::ERROR_STATUS_BAN;
			$return = 0;
		}
		else 
		{
			$error = UserIdentity::ERROR_NONE;
			$return = 1;
		}

		if($error && $render)
		{
			$this->controller->render('hoauth.views.yiiUserError', array(
				'errorCode' => $error,
				'user' => $user,
				));
		}

		return $return;
	}

	public function getUseYiiUser()
	{
		return self::$useYiiUser;
	}

	public function setUseYiiUser($value)
	{
		self::$useYiiUser = $value;
	}

	public static function t($message,$params=array(),$source=null,$language=null)
	{
		return Yii::t('HOAuthAction.root', $message,$params,$source,$language);
	}
    
    public function saveProfile($user, $userProfile, $provider)
    {
        if(!$user->profile)
        {
            $profile = new Profile();        
            // enabling register mode
            // old versions of yii
            $profile->regMode = true;
        } 
        else
            $profile = $user->profile;

        if(!$profile->user_id) $profile->user_id = $user->primaryKey;
        if(!$profile->firstname) $profile->firstname = $userProfile->firstName;
        if(!$profile->lastname) $profile->lastname = $userProfile->lastName;
        
        if(!$profile->gender)
        {
            switch($userProfile->gender)
            {
                case 'male':
                $profile->gender = 'M';
                break;
                case 'female':
                $profile->gender = 'F';
                break;
                default:
                break;
            }
        }
        switch($provider)
        {
            case 'Facebook':
            if(!$profile->facebook) $profile->facebook = $userProfile->profileURL;
            break;
            case 'LinkedIn':
            if(!$profile->linkedin) $profile->linkedin = $userProfile->profileURL;
            break;
            case 'Twitter':
            if(!$profile->twitter) $profile->twitter = $userProfile->profileURL;
            break;
            default:
            break;
        }

        if(!$profile->profile_picture || $profile->profile_picture==1)
        {
            $content = $this->getSslPage($userProfile->photoURL);
            $filename = Yii::getPathOfAlias('webroot').'/images/'.$provider.$user->primaryKey.'.jpg';        
            file_put_contents($filename, $content);

            $model_img=new Image;
            $model_img->name=$provider.$user->primaryKey.'.jpg';
            $model_img->extension='image/jpeg';
            //$model_img->size=$profile->pic->size;	

            if($model_img->save()){
                $profile->profile_picture=$model_img->id;
            }   
        }

        if(!$profile->telephone)
        {
            $telephone = preg_replace('/^([+]?[0-9 ]+)$/', '', $userProfile->phone);
            if($telephone != '') $profile->telephone = $telephone;
        }

        return $profile;
        
    }
    
    function getSslPage($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
            
}
