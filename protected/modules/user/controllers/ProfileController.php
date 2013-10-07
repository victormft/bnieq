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
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('profile', 'edit', 'suggestPerson', 'initPerson'),
				'users'=>array('@'),
			),
            array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('updateed', 'updatelocation', 'updateroles', 'updateskills', 'updatesectors'),
                'verbs'=>array('POST'),
				'users'=>array('@'),
			),
            array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    
	/**
	 * Shows a particular model.
	 */
	public function actionProfile($username=NULL)
	{
        if($username==NULL)
        {
            $model=$this->loadUser(Yii::app()->user->id);
        }
        else            
            $model = $this->loadModel($username);
        
	    $this->render('profile',array(
            'model'=>$model,
            'profile'=>$model->profile,
	    ));
	}
    
    public function actionEdit($username)
	{	        
		$model = $this->loadModel($username);
        if (!UserModule::isAdmin() && $model->id != Yii::app()->user->id) 
		    throw new CHttpException(403, 'You cannot edit this profile.');
        
        $profile = $model->profile;  
        
        if(isset($_POST['Profile']['pic']))
		{			
			$profile->pic=CUploadedFile::getInstance($profile,'pic');
			
			if($profile->pic !== null && $profile->validate())
			{
			
				if($profile->profile_picture==1)
				{
					$fileName=$profile->pic;
					$rnd = rand(0,99999999);  // generate random number between 0-99999999
					$extension_array = explode('.', $fileName); //extension of the file
					$extension=end($extension_array);
					$newFileName = md5("{$rnd}-{$fileName}").'.'.$extension;  // random number + file name
								
					$profile->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);

					$model_img=new Image;
					$model_img->name=$newFileName;
					$model_img->extension=$profile->pic->type;
					$model_img->size=$profile->pic->size;	
				
				
					if($model_img->save()){
						$profile->profile_picture=$model_img->id;
					}
					
					if($profile->save())
					{
						$this->render('edit',array(
                            'model'=>$model,
                            'profile'=>$profile,
                        ));
					}
				}
				else
				{
					/*
					$model->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$model->logo0->name);
					
					$img=Image::model()->findByPk($model->logo);
					$ext_arr = explode('.', $img->name);
					$ext = end($ext_arr);
					$new_name=md5($img->name).'.'.$ext;
					
					$img->name=$new_name;
					
					$img->save();
					
					$model->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$img->name);
					
					$this->refresh();
					*/
					unlink(Yii::getPathOfAlias('webroot').'/images/'.$profile->logo->name);
					
					$img=Image::model()->findByPk($profile->profile_picture);
					$ext_arr = explode('.', $img->name);
					$ext = end($ext_arr);
					$new_name=md5($img->name).'.'.$ext;
					
					$img->name=$new_name;
					
					$img->save();
					
					$profile->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$img->name);
					
					$this->refresh();
				}
			}
		}
		$this->render('edit',array(
            'model'=>$model,
            'profile'=>$profile,
		));
	}
    
    public function actionUpload()
    {
        $file = CUploadedFile::getInstanceByName('file');
        $file->saveAs(Yii::getPathOfAlias('webroot').'images/'.$file->getName());
        echo Yii::app()->baseUrl.'/images/'.$file->getName();
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
    public function loadModel($username=null)
	{
        if($this->_model===null)
        {
            if($username!==null || isset($_GET['username']))
                $this->_model=User::model()->find('username=:username',
                                            array(
                                              ':username'=>$username!==null ? $username : $_GET['username'],
                                            ));
            if($this->_model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }
		return $this->_model;
	}
    
    public function actions()
	{
		return array(
		
			'suggestPerson'=>array(
				'class'=>'editable.XSelect2SuggestAction',
				'modelName'=>'Cidade',
				'methodName'=>'suggestPerson',
				'limit'=>30
			),
            'initPerson'=>array(
				'class'=>'editable.XSelect2InitAction',
				'modelName'=>'Cidade',
				'textField'=>'nome',
			),
		
		);
	}
}