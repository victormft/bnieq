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
				'actions'=>array('index','view', 'viewName'),
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
	
				$model->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$model->pic);
				$model_img=new Image;
				$model_img->name=$model->pic->name;
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
	public function actionUpdate($name)
	{
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
		
		if(isset($_GET['Startup']))
			$model->attributes=$_GET['Startup'];
		
		if(isset($_GET['ajax']) && $_GET['ajax']=='startupslistview')   {
            $this->renderPartial('index',array(
                'dataProvider'=>$model,
            ));
        } else  {
            $this->render('index',array(
                'dataProvider'=>$model,
            ));
        }    
		
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
}
