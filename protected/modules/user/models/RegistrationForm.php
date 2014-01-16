<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;
    public $role;


    public function rules() {
		$rules = array(
			array('username, password, verifyPassword, email', 'required', 'message' => UserModule::t("Required")),
			array('username', 'length', 'max'=>128, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 128 characters).")),
            array('username','in','range'=>array('user','messages','pitch','site','startup','message','rights'),'allowEmpty'=>false, 'not'=>true, 'message' => 'Username inválido'),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
            array('newsletter', 'in', 'range'=>array(0,1)),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			//array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_.]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
		);
        
        /* cagar pro captcha
		if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
			array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		}
        */
		
		array_push($rules,array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")));
		return $rules;
	}
    
    /**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>UserModule::t("Username"),
			'password'=>UserModule::t("Password"),
            'verifyPassword'=>UserModule::t("Verify Password"),
            'newsletter' => UserModule::t('Keep me updated'),
            'role' => UserModule::t('Eu sou'),
		);
	}
	
}