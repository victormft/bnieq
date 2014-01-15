<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	public $layout='//layouts/column2';
	
	private $_model;
    private $_modelS;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view','startups', 'updatestartup', 'viewstartup', 'deletestartup', 'reportpop'),
				'users'=>UserModule::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
        ));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		$profile=new Profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$profile->user_id=$model->id;
					$profile->save();
				}
				$this->redirect(array('/user/profile','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
				$model->save();
				$profile->save();
				$this->redirect(array('view','id'=>$model->id));
			} else $profile->validate();
		}

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$profile = Profile::model()->findByPk($model->id);
			$profile->delete();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
    
    
	public function actionStartups()
	{
		$model=new Startup('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Startup']))
            $model->attributes=$_GET['Startup'];
		
		if(isset($_GET['Startup_sort']) || isset($_GET['ajax']))
		{
			$model->rand=false;
		}
			
        $this->render('index_startup',array(
            'model'=>$model,
        ));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}
    
	public function actionUpdateStartup()
	{
		$model=$this->loadStartup();
		$this->performAjaxValidation($model);
		if(isset($_POST['Startup']))
		{
			$model->name=$_POST['Startup']['name'];
			$model->one_line_pitch=$_POST['Startup']['one_line_pitch'];
			$model->selecionada=$_POST['Startup']['selecionada'];
			
			
			if($model->validate()) {
				$model->save();
				$this->redirect(array('startups'));
			} 
		}

		$this->render('update_startup',array(
			'model'=>$model,
		));
	}
    
    public function actionViewStartup()
	{
		$model = $this->loadStartup();
		$this->render('view_startup',array(
			'model'=>$model,
		));
	}
    
    public function actionDeleteStartup()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadStartup();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin/startups'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
    
    public function actionReportPop($id)
    {
        $model = User::model()->findbypk($id);
       
        $provider = $model->getReports();
        
        $html='<div>';
        
        
        foreach($provider as $arr)
        {
            $user=User::model()->findbypk($arr->user_id);
            $html.='
                <div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
                    <div class="team-item">
                        <div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $user->profile->logo->name .'" /></div>
                        <div class="team-text" >
                                <div class="team-resume" style="width:70%; float:left;"><b>'. $arr->text .'</div>
                                <div style="float:right;">'. date("d-m-Y", strtotime($arr->time)) .'</div>
                        </div>
                    </div>
                </div>
                <div class="spacing-1"></div>
                ';
        }
        
        $html.='</div>';
        
        echo CJSON::encode(array(
            'res'=>$html,
        ));
        exit;
    }

        /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
    
    public function loadStartup()
	{
		if($this->_modelS===null)
		{
			if(isset($_GET['id']))
				$this->_modelS=Startup::model()->findbyPk($_GET['id']);
			if($this->_modelS===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_modelS;
	}
	
}