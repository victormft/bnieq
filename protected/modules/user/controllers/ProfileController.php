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
	public function actionProfile()
	{
        $model = $this->loadUser();
	    $this->render('profile',array(
            'model'=>$model,
            'profile'=>$model->profile,
	    ));
	}

	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit_Basic()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
            
            
			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();
                
                //save the roles of the user
                if(isset($_POST['rolesU']))
                {                    
                    foreach ($_POST['rolesU'] as $role)
                    {
                        $roles[] = Role::model()->find('role_id=:id', array(':id'=>$role));
                    }
                    $model->roles = $roles;
                    $model->saveWithRelated(array('roles'));
                }
                
                //save the universities of the user
                if(isset($_POST['univerU']))
                { 
                    foreach ($_POST['univerU'] as $uni)
                    {
                        $unis[] = University::model()->find('university_id=:id', array(':id'=>$uni));
                    }
                    $model->universities = $unis;
                    $model->saveWithRelated(array('universities'));
                }               
                    
                Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes are saved."));
				$this->redirect(array('/user/profile', 'id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('edit_basic',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
    
    
    public function actionUpdate()
    {
        $es = new TbEditableSaver('Profile');  //'User' is name of model to be updated
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
    
    public function ActionCheckZipCode()
    {
        echo $_GET['zipcode'];
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
}