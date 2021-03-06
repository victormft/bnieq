<?php

class PitchController extends Controller
{


	private $_startup;
	private $_viewOption;
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
			'postOnly + delete', // we only allow deletion via POST request
			'startup + create',
			'viewOption + view'
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
				'actions'=>array('index','view',  'detail'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'edit'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'viewOption'=> $this->_viewOption
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Pitch;
		$user = User::model()->findByPk(Yii::app()->user->id);
		$profile = $user->profile;
		$model->startup_id = $this->_startup->id;
		$startup = $this->_startup;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pitch']))
		{
			$valid = true;
			
			if(isset($_POST['Profile'])) {
				$profile->attributes=$_POST['Profile'];
				$valid = $profile->validate();
			}
			if(isset($_POST['Startup'])) {
				$startup->attributes = $_POST['Startup'];
				$valid = ($startup->validate() && $valid);
			}
			
			
			$model->attributes=$_POST['Pitch'];
			$valid = ($model->validate() && $valid);
			
			if($valid) {
			$startup->save(false);
			$model->save(false);
			$profile->save(false);
			
			
			$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model, 'profile'=>$profile , 'startup'=>$startup, 
		));
	}

    public function actionEdit($id)
	{
        $model=$this->loadModel($id);
       
        if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model->startup)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Pitch!'));
		
		if(isset($_POST['Startup']['pic']))
		{
		
			
			$this->render('view_edit',array(
					'model'=>$model,
			));
			
		}
		
		else if(isset($_FILES['mult_pic']) && count($model->images)<4)
		{
	
			
			$this->render('view_edit',array(
					'model'=>$this->loadModel($name),
			));
					
		}
		
		
		else
		{
			/*
            if($model->published==0)
			{
				$user = Yii::app()->getComponent('user');
				$user->setFlash(
					'warning',
					'<strong>MODO RASCUNHO</strong><br/><br/>Para publicar o perfil, preencha no mínimo os campos "Setor(es)", "Produto" e "Estágio" e clique no botão \'Publicar\'.'
				);
			}
             * 
             */
				
			$this->render('edit',array(
				'model'=>$model,
			));
		}
	}
	
    public function actionUpdate(/*$name*/)
	{
        $model=$this->loadModel($_POST['pk']);
        if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model->startup)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));	
			
		
		$es = new TbEditableSaver('Pitch');  //'Startup' is name of model to be updated
        $es->update();
		
		/*
		$n_model=$this->loadModelId($_POST['pk']);
		
		if($_POST['name']=='product_description' && empty($model->product_description))
		{
			$n_model->completion=$model->completion+10;
			$n_model->save();
		}

		else if($_POST['name']=='company_stage' && empty($model->company_stage))
		{
			$n_model->completion=$model->completion+5;
			$n_model->save();
		}	
		
		else
		{
			if(!($_POST['name']=='facebook' || $_POST['name']=='linkedin' || $_POST['name']=='twitter'))
			{
				if(empty($model->$_POST['name']) && !empty($n_model->$_POST['name']))
				{
					$n_model->completion=$model->completion+4;
					$n_model->save();
				}
				else if(!empty($model->$_POST['name']) && empty($n_model->$_POST['name']))
				{
					$n_model->completion=$model->completion-4;
					$n_model->save();
				}
			}
		}
         * 
         */		
	}
    
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*
    public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pitch']))
		{
			$model->attributes=$_POST['Pitch'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
     * 
     */

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
    
    
    
    public function actionIndex()
	{
		//$dataProvider=new CActiveDataProvider('Pitch');
		$model=new Pitch('search');
		$model->unsetAttributes();
		
		if(isset($_GET['name'])) {
		
			if(isset($_GET['qa']))
			{
				$this->_viewOption = 'q&a';
			}
			else if(isset($_GET['update']))
			{
				$this->_viewOption = 'update';
			}
			else
				$this->_viewOption = 'details';
		
			$name = $_GET['name'];
			
			$startup_model = Startup::model()->find('startupname=:name',
										array(
										  ':name'=>$name,
										));
			
			if(isset($startup_model)) {
			
				$pitch_model = Pitch::model()->find('startup_id=:id',
										array(
										  ':id'=>$startup_model->id,
										));
				if(isset($pitch_model))
					$this->render('view',array(
					'model'=>$pitch_model,
					'viewOption' =>$this->_viewOption,
					));
		}
			else
				throw new CHttpException(403, 'Nome de startup inválido.');
				
		}
		else {
		
		if(isset($_GET['g']))
		{
			//if($_GET['g']=='Selecionadas')
				//$model->selecionada=1;
			
			/*else if($_GET['g']=='Populares')
				$model->group=$_GET['g'];
				
			else if($_GET['g']=='Novidades')
				$model->group=$_GET['g'];*/
				if($_GET['g']=='Financiada')
				$model->sort_funded = 1;
		}
		
		if(isset($_GET['c_stage']))
			$model->c_stage_sort=$_GET['c_stage'];	
		
		$this->render('index',array(
			'dataProvider'=>$model,
		));
		}
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pitch('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pitch']))
			$model->attributes=$_GET['Pitch'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionDetail() {
	if(isset($_GET['name'])) {
		
		
		
			$name = $_GET['name'];
			
			$startup = Startup::model()->find('startupname=:name',
										array(
										  ':name'=>$name,
										));
										
	$this->renderPartial('_detail',array(
			'model'=>$this->loadModel($startup->pitches[0]->id),
		));
	
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pitch the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pitch::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
    /*
     * COM PROBLEMA!!!! STARTUP TEM MAIS DE UM PITCH
     */
    public function loadModelByName($name)
	{
        $startup = Startup::model()->find('startupname=:name',
										array(
										  ':name'=>$name,
										));        
		$model = $startup->pitch;
        
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param Pitch $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pitch-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	//need to put some secure to filter, loading the startup only if it's user is the same of current logged user
	public function filterStartup($filterchain) {
		if(isset($_GET['name'])) {
		
		
		
			$name = $_GET['name'];
			
			$this->_startup = Startup::model()->find('startupname=:name',
										array(
										  ':name'=>$name,
										));
		
		
		
		
		
			//$this->_startup = Startup::model()->findByPk($_GET['startupId']);
			
			if($this->_startup === null)
				throw new CHttpException(404,'A página requisitada não existe');
			
			
			
			//estou fazendo com que o create utilize startupname como parametro
			
			
			if($this->_startup->pitches != NULL)
				throw new CHttpException(403, 'Somente um pitch por vez.');
			//verifies if startupId matchs with one of the startups that belongs to user
			$authorization = false;
			$user = User::model()->findByPk(Yii::app()->user->id);
			
			foreach($user->startups as $startup) {
			
			if($startup->startupname== $_GET['name'])
				$authorization = true;	
			}
			
			if(!$authorization)
				throw new CHttpException(403,' Operação não permitida');
				
			if(!$this->_startup->pitchProfile->complete)
				throw new CHttpException(403,'Complete dos dados da startup');
		}	
			else
			throw new CHttpException(403, 'Preciso do StartupId');
		$filterchain->run();
			
	}
	public function filterViewOption($filterchain)
	{
		if(isset($_GET['qa']))
		{
			$this->_viewOption = 'q&a';
		}
		else if(isset($_GET['update']))
		{
			$this->_viewOption = 'update';
		}
		else
			$this->_viewOption = 'details';
		
		
		
	
	}
	
	
}
