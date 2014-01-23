<?php

class SettingsController extends Controller
{
	public $layout='//layouts/column1';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
        
	/**
	 * Shows a particular model.
	 */
    public function actionIndex()
	{
        $this->redirect(array("general"));
	}
    
	public function actionGeneral()
	{
        $model = User::model()->findbyPk(Yii::app()->user->id);
		if (Yii::app()->user->id) {
			
			// ajax validator
            if(isset($_POST['ajax']) && ($_POST['ajax']==='general-form' || $_POST['ajax']==='newsletter-form'))
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['User'])) 
            {
                if(isset($_POST['User']['newsletter']))
                {                    
                    $model->newsletter=$_POST['User']['newsletter'];
                    if($model->validate()) {
                        $model->save();
                        Yii::app()->user->setFlash('success',UserModule::t("Thanks!"));
                        $this->redirect(array("general"));
                    }
                }
                else
                {
                    $model->attributes=$_POST['User'];
                    if($model->validate()) {
                        $model->save();
                        Yii::app()->user->name = $model->username;
                        Yii::app()->user->setFlash('success',UserModule::t("Changes saved."));
                        $this->redirect(array("general"));
                    }
                }                
			}
			$this->render('general',array('model'=>$model));
	    }
        else $this->redirect(Yii::app()->controller->module->loginUrl);
	}
    
    public function actionPassword()
	{
        $model = new UserChangePassword;
        $user = User::model()->notsafe()->findByPk(Yii::app()->user->id);
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
                    Yii::app()->user->setFlash('success',UserModule::t("New password is saved."));
                    $this->redirect(array("password"));
                }
			}
			else $this->render('changepassword',array('model'=>$model, 'user'=>$user));
	    }
        else $this->redirect(Yii::app()->controller->module->loginUrl);
	}
    
    public function actionPasswordNull()
	{
        $model = new UserChangePasswordNull;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepasswordnull-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePasswordNull'])) {
                $model->attributes=$_POST['UserChangePasswordNull'];
                if($model->validate()) {
                    $new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
                    $new_password->password = UserModule::encrypting($model->password);
                    $new_password->activkey = UserModule::encrypting(microtime().$model->password);
                    $new_password->save();
                    Yii::app()->user->setFlash('success',UserModule::t("New password is saved."));
                    $this->redirect($this->createUrl('settings/password'));
                }
			}
			else EQuickDlgs::renderPartial('_changepasswordnull',array('model'=>$model));
	    }
        else $this->redirect(Yii::app()->controller->module->loginUrl);
	}
    
    public function actionSocial()
	{
        $model = User::model()->findbyPk(Yii::app()->user->id);
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='general-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['User'])) {
					$model->attributes=$_POST['User'];
					if($model->validate()) {
						$model->save();
                        Yii::app()->user->name = $model->username;
						Yii::app()->user->setFlash('success',UserModule::t("Changes saved."));
						$this->redirect(array("general"));
					}
			}
			$this->render('social',array('model'=>$model));
	    }
        else $this->redirect(Yii::app()->controller->module->loginUrl);
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