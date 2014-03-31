<?php

class ThreadController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			//'ajaxOnly + index',
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
				'actions'=>array('index','view'),
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
	public function actionView($id)
	
	{
		$model = $this->loadModel($id);
		$model->views++;
		$model->save();
                
                $startup_model = Startup::model()->findByPk($model->startup_id);
                $pitch_model = $startup_model->pitches[0];
                
		$this->render('view',array(
			'model'=>$model ,
                        'pitch_model' => $pitch_model,
                        'startup_model' => $startup_model,
                        'param' => 'qa',
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Thread;
		$model_post = new Post;
		
		$user = User::model()->findByPk(Yii::app()->user->id);
		
		$model->user_id = $user->id;
		$model_post->user_id = $user->id;
		if(isset($_GET['startupId']))
				$model->startup_id = $_GET['startupId'];
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Thread']))
		{
			
			$valid = true;
			
			if(isset($_POST['Post'])) {
			
				$model_post->attributes=$_POST['Post'];
				$model_post->setCreateTime(time());
			}
			
			
			
		
			$model->attributes=$_POST['Thread'];
			$model->setCreateTime(time());
			$model->last_post = $model->create_time;
			$model->last_post_user_id = $model->user_id;
			
			
			$valid = ($model->validate());
			
			$model_post->thread_id = $model->id;
			$valid = $model_post->validate() && $valid;
			
			if($valid) {
				if($model->save(false)) 
					$model_post->thread_id = $model->id;
					if($model_post->save(false))
						$this->redirect(array('view','id'=>$model->id));
			}
		}
                
                $startup_id = $_GET['startupId'];
                $startup_model = Startup::model()->findByPk($startup_id);
                $pitch_model = $startup_model->pitches[0];
                
		$this->render('create',array(
			'model'=>$model, 
                        'model_post'=>$model_post,
                        'startup_model' => $startup_model,
                        'pitch_model' => $pitch_model,
                        'param' => 'qa',
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Thread']))
		{
			$model->attributes=$_POST['Thread'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$startup_id = $_GET['startupId'];
                $startup_model = Startup::model()->findByPk($startup_id);
                $pitch_model = $startup_model->pitches[0];
		$dataProvider=new CActiveDataProvider('Thread', array(
		'criteria'=>array(
        'condition'=>'startup_id='.$startup_id,
        'order'=>'create_time ASC',
    ),));
	
		/*$dataProvider=new CActiveDataProvider('Thread', array(
			'criteria'=>array(
			'order'=>'last_post DESC',
    ),));*/
	
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
                        'pitch_model'=>$pitch_model,
                        'startup_model'=>$startup_model,
                        'param' => 'qa',
		));
	}
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Thread('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Thread']))
			$model->attributes=$_GET['Thread'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Thread the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Thread::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Thread $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='thread-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function filterStartup($filterchain) {
	
		if(isset($_GET['startupId'])) {
				$this->_startup = Startup::model()->findByPk($_GET['startupId']);
				if($this->_startup === null)
					throw new CHttpException(404,'A página requisitada não existe');
		}
	}
}
