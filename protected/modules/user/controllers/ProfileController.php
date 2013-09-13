<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile($username)
	{
        $model = $this->loadModel($username);
	    $this->render('profile',array(
            'model'=>$model,
            'profile'=>$model->profile,
	    ));
	}
    
    public function actionEdit($username)
	{	
		$model = $this->loadModel($username);
		$this->render('edit',array(
            'model'=>$model,
            'profile'=>$model->profile,
		));
	}
    
    public function actionUpdateLocation()
    {
        $model = $this->loadUser($_POST['pk']);
        $profile = $model->profile;
        if($_POST['value']==0) $profile->location=NULL;
        else $profile->location = $_POST['value'];
        $profile->save();         
    }
    
    public function actionUpdateRoles()
    {        
        $model = $this->loadUser($_POST['pk']);
        $vals = array();
        if(isset($_POST['value']))
        {
            foreach ($_POST['value'] as $val)
            {
                $vals[] = Role::model()->find('role_id=:id', array(':id'=>$val));
            }
        }
        $model->roles = $vals;
        $model->saveWithRelated(array('roles'));            
    }
    
    public function actionUpdateSkills()
    {
        $model = $this->loadUser($_POST['pk']);
        $vals = array();
        if(isset($_POST['value']))
        {
            foreach ($_POST['value'] as $val)
            {
                $vals[] = Skill::model()->find('skill_id=:id', array(':id'=>$val));
            }
        }
        $model->skills = $vals;
        $model->saveWithRelated(array('skills'));            
    }
    
    public function actionUpdateSectors()
    {
        $model = $this->loadUser($_POST['pk']);
        $vals = array();
        if(isset($_POST['value']))
        {
            foreach ($_POST['value'] as $val)
            {
                $vals[] = Sector::model()->find('sector_id=:id', array(':id'=>$val));
            }
        }
        $model->sectors = $vals;
        $model->saveWithRelated(array('sectors'));            
    }
        
    public function actionUpdateEd()
    {
        $es = new TbEditableSaver('Profile');  //'Profile' is name of model to be updated
        $es->update();
    }
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}
    
    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}   
    
    //load User from username
    public function loadModel($username)
	{
		$model=User::model()->find('username=:username',
										array(
										  ':username'=>$username,
										));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}