<?php

class StartupController extends Controller
{
	
	
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view', 'viewName', 'editsectors', 'edit', 'follow', 'unfollow'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Displays a particular model.
	* @param integer $id the ID of the model to be displayed
	*/
	public function actionView($name)
	{
		$this->render('view',array(
		'model'=>$this->loadModel($name),
		));
	}
	
	public function actionEdit($name)
	{
	
		$model=$this->loadModel($name);
		
		if(isset($_POST['Startup']['pic']))
		{
			
			$model->pic=CUploadedFile::getInstance($model,'pic');
			
			if($model->pic !== null && $model->validate())
			{
			
				if($model->logo==1)
				{
					$fileName=$model->pic;
					$rnd = rand(0,99999999);  // generate random number between 0-99999999
					$extension_array = explode('.', $fileName); //extension of the file
					$extension=end($extension_array);
					$newFileName = md5("{$rnd}-{$fileName}").'.'.$extension;  // random number + file name
								
					$model->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);

					$model_img=new Image;
					$model_img->name=$newFileName;
					$model_img->extension=$model->pic->type;
					$model_img->size=$model->pic->size;	
				
				
					if($model_img->save()){
						$model->logo=$model_img->id;
					}
					
					if($model->save())
					{
						$this->render('view_edit',array(
						'model'=>$this->loadModel($name),
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
					unlink(Yii::getPathOfAlias('webroot').'/images/'.$model->logo0->name);
					
					$img=Image::model()->findByPk($model->logo);
					$ext_arr = explode('.', $img->name);
					$ext = end($ext_arr);
					$new_name=md5($img->name).'.'.$ext;
					
					$img->name=$new_name;
					
					$img->save();
					
					$model->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$img->name);
					
					$this->refresh();
				}
			}
		}
		
		
		
		$this->render('view_edit',array(
		'model'=>$model,
		));
	}
	

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{
		$model=new Startup;
		// Image Instance
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Startup']))
		{
			$model->attributes=$_POST['Startup'];
			
			//treating the image
			$model->pic=CUploadedFile::getInstance($model,'pic');
			
			
			if($model->pic !== null && $model->validate()){
				
				$fileName=$model->pic;
				$rnd = rand(0,99999999);  // generate random number between 0-99999999
				$extension_array = explode('.', $fileName); //extension of the file
				$extension=end($extension_array);
				$newFileName = md5("{$rnd}-{$fileName}").'.'.$extension;  // random number + file name
							
				$model->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
				$model_img=new Image;
				$model_img->name=$newFileName;
				$model_img->extension=$model->pic->type;
				$model_img->size=$model->pic->size;	
			
			
				if($model_img->save()){
					$model->logo=$model_img->id;
				}
				
				else 
					$model->logo=null;
			}
			
			else
				$model->logo=1;
			
			if($model->save()){
				
				$this->redirect(array('view','name'=>$model->name));
				
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	* Updates a particular model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id the ID of the model to be updated
	*/
	public function actionUpdate(/*$name*/)
	{
		$es = new TbEditableSaver('Startup');  //'Startup' is name of model to be updated
        $es->update();
	
	/*
		$model=$this->loadModel($name);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Startup']))
		{
			$model->attributes=$_POST['Startup'];
			if($model->save())
				$this->redirect(array('view','name'=>$model->name));
		}

		$this->render('update',array(
			'model'=>$model,
		));
		
	*/	
	}

	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$model=new Startup('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['n'])) {
			$model->name=$_GET['n'];
			$model->one_line_pitch=$_GET['n'];
		}
		if(isset($_GET['c_size']))
			$model->company_size=$_GET['c_size'];	
		
		if(isset($_GET['sec']))
			$model->sectors=$_GET['sec'];	
			
		//if(isset($_GET['Startup']))
		//	$model->attributes=$_GET['Startup'];
		/*
		if(isset($_GET['ajax']) && $_GET['ajax']=='startupslistview')   {
            $this->renderPartial('index',array(
                'dataProvider'=>$model,
            ));
        } else  {
            $this->render('index',array(
                'dataProvider'=>$model,
            ));
        }    
		*/
		
		 $this->render('index',array(
                'dataProvider'=>$model,
            ));
		
		/*
		$this->render('index',array(
			'dataProvider'=>$model->search(),
			'model'=>$model,
		));
		*/
	}

	/**
	* Manages all models.
	*/
	public function actionAdmin()
	{
		$model=new Startup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Startup']))
			$model->attributes=$_GET['Startup'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	* @param integer the ID of the model to be loaded
	*/
	public function loadModel($name)
	{
		$model=Startup::model()->find('name=:name',
										array(
										  ':name'=>$name,
										));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	

	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='startup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionEditSectors()
    {	
		$model = $this->loadModel($_GET['name']);
         
        if(isset($_POST['sectors']))
        {                    
            foreach ($_POST['sectors'] as $sector)
            {
                $sectors[] = Sector::model()->find('sector_id=:id', array(':id'=>$sector));
            }
            $model->sectors = $sectors;
            $model->saveWithRelated(array('sectors'));
        }
        else 
        {
            $model->sectors = array();
            $model->saveWithRelated(array('sectors'));
        }
        $this->renderPartial('_sectors', array('model'=>$model)); 
    }
	
	public function actionFollow()
	{
		if(Yii::app()->request->isAjaxRequest )
		{
			$model = $this->loadModel($_GET['name']);
			
			if(!$model->users)
			{
				$model->users=User::model()->findbyPk(Yii::app()->user->id);
				$model->saveWithRelated(array('users'));
				return count($model->users);
			}
			
			else 
			{
				
				if($model->hasUserFollowing(Yii::app()->user->id))
				{
					return count($model->users);
				}
				
				$model->users=User::model()->findbyPk(Yii::app()->user->id);
				$model->saveWithRelated( array('users' => array('append' => true)));
				return count($model->users);
			}		
		}
		
		else
			throw new CHttpException(404, 'Page not found.');
	}
	
	public function actionUnfollow()
	{
		if(Yii::app()->request->isAjaxRequest )
		{
			$model = $this->loadModel($_GET['name']);
			
			if ($model->hasUserFollowing(Yii::app()->user->id))
			{
				$startup_follow=StartupFollow::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>Yii::app()->user->id, ':s_id'=>$model->id));
				$startup_follow->delete();
				return count($model->users);
			}
			
			return count($model->users);
		}
		
		else
			throw new CHttpException(404, 'Page not found.');	
	}
}