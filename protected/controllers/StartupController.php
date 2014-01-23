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
				'actions'=>array('create', 'edit'/* tinha parado aqui... o resto veio do * acima*/,'editsectors', 'multPic', 'publish', 'multUp', 'multDel', 'logoUp', 'autoTest', 'pressUrl', 'followPop'),
				'users'=>array('@'),
			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'updateName', 'updateLocation', 'updateSectors', 'follow', 'unfollow', 'approve', 'addTeam', 'addPress', 'addTraction', 'addPast', 'deleteTeam', 'deletePress', 'deleteTraction', 'deletePast', 'RefreshStartupName', 'delete'),
				'users'=>array('@'),
                'verbs'=>array('POST'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
		//setting returnurl in case user is not logged in - necessary because of closed fields
		if(Yii::app()->user->isGuest)
		{
			$app=Yii::app();
			$app->user->setReturnUrl($app->request->getUrl());
		}
		
		$model=$this->loadModel($name);
		
		if($model->published==1)
		{
			$this->render('profile',array(
			'model'=>$model,
			));
		}
		
		else
		{
			 if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
				throw new CHttpException(404,UserModule::t('Page not found.'));
			
			else
				$this->redirect(array('/edit/'.$model->startupname));
		}
	}
	
	public function actionPublish($name)
	{
		$model=$this->loadModel($name);
       
		$model->scenario='publish';
		
		$model->sec=$model->sectors;
		
        if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
		if(!$model->sectors || !$model->product_description || !$model->company_stage)
		{
			$alert_sectors=empty($model->sectors)?'<li>Setor(es)</li>':'';
			$alert_product=empty($model->product_description)?'<li>Produto</li>':'';
			$alert_stage=empty($model->company_stage)?'<li>Estágio</li>':'';
			/*
			$err=array();
			if(!$model->sectors) $err['sec']=UserModule::t("Required");
			if(!$model->product_description) $err['product']=UserModule::t("Required");
			if(!$model->company_stage) $err['c_stage']=UserModule::t("Required");
			*/
			//$model->saveAttributes(array('err'=>$err));
			
			$user = Yii::app()->getComponent('user');
            $user->setFlash(
                'error',
                '<strong>Atenção!</strong> Para publicar o perfil, preencha no mínimo os campos listados a seguir:<p><ul>'.$alert_product.$alert_sectors.$alert_stage.'</ul></p>'
            );
			
			
			
			$this->redirect(array('/edit/'.$model->startupname));
		}

		else
		{
			$model->published=1;
			
			if($model->save())
				$this->redirect(array('/'.$model->startupname));
			
			else
			{
				$user = Yii::app()->getComponent('user');
				$user->setFlash(
					'error',
					'<strong>Ops!</strong> Ocorreu algum erro. Tente novamente.'
				);
				$this->redirect(array('/edit/'.$model->startupname));	
			}
		}	 

	}
	
	public function actionEdit($name)
	{
        $model=$this->loadModel($name);
       
        if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
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
					
					$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
					
					if($image->width>=$image->height)
					{
						$image->resize(120, 120, ImageExt::WIDTH)->sharpen(25);
					}
					else
						$image->resize(120, 120, ImageExt::HEIGHT)->sharpen(25);
					
					$image->save(); // or $image->save('images/small.jpg');
					
					$model_img=new Image;
					$model_img->name=$newFileName;
					$model_img->extension=$model->pic->type;
					$model_img->size=0;//$model->pic->size;	
				
				
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
					
					$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$img->name);
					
					if($image->width>=$image->height)
					{
						$image->resize(120, 120, ImageExt::WIDTH)->sharpen(25);
					}
					else
						$image->resize(120, 120, ImageExt::HEIGHT)->sharpen(25);
					
					$image->save(); // or $image->save('images/small.jpg');
					
					$this->refresh();
				}
			}
			
			$this->render('view_edit',array(
					'model'=>$model,
			));
			
		}
		
		else if(isset($_FILES['mult_pic']) && count($model->images)<4)
		{

			$model=$this->loadModel($name);
			
			$img_list=CUploadedFile::getInstancesByName('mult_pic');
			
			foreach($img_list as $mult_pic)
			{

				$model->mult_pic=$mult_pic;
				
				if($model->mult_pic !== null && $model->validate())
				{
				
					$fileName=$model->mult_pic;
					$rnd = rand(0,99999999);  // generate random number between 0-99999999
					$extension_array = explode('.', $fileName); //extension of the file
					$extension=end($extension_array);
					$newFileName = md5("{$rnd}-{$fileName}").'.'.$extension;  // random number + file name
								
					$model->mult_pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
					
					$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
					$image->resize(400, 300)->quality(75)->sharpen(20);
					$image->save(); // or $image->save('images/small.jpg');
					
					$model_img=new Image;
					$model_img->name=$newFileName;
					$model_img->extension=$model->mult_pic->type;
					$model_img->size=0;//$model->pic->size;	
					$model_img->save();	

					$model->images=$model_img;
					$model->saveWithRelated(array('images' => array('append' => true)));
					
					
				
				}
				else
					$this->refresh();
			
			}	
			
			$this->render('view_edit',array(
					'model'=>$this->loadModel($name),
			));
					
		}
		
		
		else
		{
			if($model->published==0)
			{
				$user = Yii::app()->getComponent('user');
				$user->setFlash(
					'warning',
					'<strong>MODO RASCUNHO</strong><br/><br/>Para publicar o perfil, preencha no mínimo os campos "Setor(es)", "Produto" e "Estágio" e clique no botão \'Publicar\'.'
				);
			}
				
			$this->render('view_edit',array(
				'model'=>$model,
			));
		}
	}
	

	/**
	* Creates a new model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	*/
	public function actionCreate()
	{
		$model=new Startup('create');
		// Image Instance
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Startup']))
		{
			$model->name=$_POST['Startup']['name'];
			$model->one_line_pitch=$_POST['Startup']['one_line_pitch'];
			$model->location=$_POST['Startup']['location'];
			
			$model->name = preg_replace('/[\/%><=#\$]/', '', $model->name);
			
			// !!!!!!!!!!!! formatting startupname !!!!!!!!!!!!!!!!!!
			$startupname = $_POST['Startup']['name'];
			$startupname = trim($startupname);
			$startupname = preg_replace('/[\/\&%><=#.\$]/', '', $startupname);
			$startupname = preg_replace('/[\"\']/', '', $startupname);
			$startupname = preg_replace('/[-_]/', ' ', $startupname);
			$startupname = preg_replace('/\s+/', '-', $startupname);
			$startupname = strtr(utf8_decode($startupname), utf8_decode('ÀÁÂÃÄÈÉÊËÌÍÎÏĨÒÓÔÕÖÙÚÛÜŨÇàáâãäèéêëìíîïĩòóôõöùúûüũç'), 'AAAAAEEEEIIIIIOOOOOUUUUUCaaaaaeeeeiiiiiooooouuuuuc');		
			$startupname = strtolower($startupname);
			
			if($name_num = Startup::model()->findAll('startupname REGEXP CONCAT("^",:startupname, "-*", "[0-9]*","$")', array(':startupname'=>$startupname)))
			{
				$last_elem = end($name_num);
				$last_num = substr(strrchr($last_elem->startupname, "-"), 1);
				$new_num = $last_num + 1;
				$startupname=$startupname."-".$new_num;
			}
			
			$model->startupname = $startupname; 
	
			// !!!!!!!!!!!! end formatting startupname !!!!!!!!!!!!!!!
			
			$model->published=0;
            
            $model->setCreateTime(time());
			
			$model->completion=30;
	
			
			//treating the image
			$model->pic=CUploadedFile::getInstance($model,'pic');
			
			
			if($model->pic !== null && $model->validate()){
				
				$fileName=$model->pic;
				$rnd = rand(0,99999999);  // generate random number between 0-99999999
				$extension_array = explode('.', $fileName); //extension of the file
				$extension=end($extension_array);
				$newFileName = md5("{$rnd}-{$fileName}").'.'.$extension;  // random number + file name
							
				$model->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
				
				$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
				
				//!!!!!!!!!! building image ratio !!!!!!!!!!!!!
				/*
				$ratio = 1;
				
				if($image->width !== 0)
				{
					$ratio = $image->height/$image->width;
				}
				$new_height=round(120*$ratio);
				*/
				//!!!!!!!!!! finishing the ratio !!!!!!!!!!!!!!
				if($image->width>=$image->height)
				{
					$image->resize(120, 120, ImageExt::WIDTH)->sharpen(25);
				}
				else
					$image->resize(120, 120, ImageExt::HEIGHT)->sharpen(25);
				
				$image->save(); // or $image->save('images/small.jpg');
				
				$model_img=new Image;
				$model_img->name=$newFileName;
				$model_img->extension=$model->pic->type;
				$model_img->size=0;//$model->pic->size;		
			
			
				if($model_img->save()){
					$model->logo=$model_img->id;
					$model->completion=$model->completion + 10;
				}
				
				else 
					$model->logo=1;
			}
			
			else
				$model->logo=1;
			            
			if($model->save())
            {
                //who create is founder
                $user_startup = new UserStartup;
                $user_startup->user_id = Yii::app()->user->id;
                $user_startup->startup_id = $model->id;
                $user_startup->position = "Founder";
                $user_startup->approved = 1;
                
                if($user_startup->save())
                {		
                    $auth = Yii::app()->authManager;
                    $auth->assign("StartupOwner",Yii::app()->user->id);
                    $this->redirect(array('/edit/'.$model->startupname));
                }				
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
        $model=$this->loadModelId($_POST['pk']);
        if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));	
			
		
		$es = new TbEditableSaver('Startup');  //'Startup' is name of model to be updated
        $es->update();
		
		
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
	
	public function actionUpdateName()
	{
        $model=$this->loadModelId($_POST['pk']);
        if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
			
		$es = new TbEditableSaver('Startup');  //'Startup' is name of model to be updated
        $es->update();
		
		$startupname = $_POST['value'];
		$startupname = trim($startupname);
		$startupname = preg_replace('/[\/\&%><=#.\$]/', '', $startupname);
		$startupname = preg_replace('/[\"\']/', '', $startupname);
		$startupname = preg_replace('/[-_]/', ' ', $startupname);
		$startupname = preg_replace('/\s+/', '-', $startupname);
		$startupname = strtr(utf8_decode($startupname), utf8_decode('ÀÁÂÃÄÈÉÊËÌÍÎÏĨÒÓÔÕÖÙÚÛÜŨÇàáâãäèéêëìíîïĩòóôõöùúûüũç'), 'AAAAAEEEEIIIIIOOOOOUUUUUCaaaaaeeeeiiiiiooooouuuuuc');		
		$startupname = strtolower($startupname);
		
		if($name_num = Startup::model()->findAll('startupname REGEXP CONCAT("^",:startupname,"-*","[0-9]*","$")', array(':startupname'=>$startupname)))
		{
			$last_elem = end($name_num);
			$last_num = substr(strrchr($last_elem->startupname, "-"), 1);
			$new_num = $last_num + 1;
			$startupname=$startupname."-".$new_num;
		}
		
		//it is necesary to reload the model after update
		$model=$this->loadModelId($_POST['pk']);
		
		$model->startupname = $startupname; 
		
		$model->save();
	}
/*
	public function actionUpdateName()
    {
		$model = $this->loadModelId($_POST['pk']);
		$model->name = $_POST['value'];
		if($model->validate())$model->save(); 
		
		
		
	}
*/	
	public function actionUpdateLocation()
    {
        $model = $this->loadModelId($_POST['pk']);
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
			
        if($_POST['value']==0) $model->location=NULL;
        else $model->location = $_POST['value'];
        
		if($model->save())
			exit;
			
		$es = new TbEditableSaver('Startup');  //'Startup' is name of model to be updated
        $es->update();
		
    }
	
	
	public function actionUpdateSectors()
    {
        $model = $this->loadModelId($_POST['pk']);
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
			
        $vals = array();
        if(isset($_POST['value']))
        {
            foreach ($_POST['value'] as $val)
            {
                $vals[] = Sector::model()->find('sector_id=:id', array(':id'=>$val));
            }
			
			if(count($vals)>3)
				exit;
			
			if(count($model->sectors)==0)
				$model->completion=$model->completion+5;
			
			$model->sectors = $vals;
			$model->saveWithRelated(array('sectors'));
			exit;
        }
		     			
		$es = new TbEditableSaver('Startup');  //'Startup' is name of model to be updated
        $es->update();
    }
	
	
	/**
	* Deletes a particular model.
	* If deletion is successful, the browser will be redirected to the 'admin' page.
	* @param integer $id the ID of the model to be deleted
	*/
	public function actionDelete($id)
	{
		$model = $this->loadModelId($id);
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModelId($id)->delete();

			if(Yii::app()->user->isSuperuser)
			{
				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
			else
				$this->redirect(Yii::app()->request->baseUrl.'/'.Yii::app()->user->username);
		}
		else
			throw new CHttpException(404,UserModule::t('It was not possible to resolve the request.'));
	}

	/**
	* Lists all models.
	*/
	public function actionIndex()
	{
		$model=new Startup('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['n'])) {
			$search_name=preg_replace('/[><=]/', '', $_GET['n']);
			$model->name=strip_tags($search_name);
			//$model->one_line_pitch=strip_tags($search_name);
		}
		if(isset($_GET['c_stage']))
			$model->company_stage=$_GET['c_stage'];	
		
		if(isset($_GET['sec']))
			$model->sectors=$_GET['sec'];	
			
		if(!empty($_GET['g']))
		{
		
			$model->default_sort=false;
			
			if($_GET['g']=='Selecionadas')
				$model->selecionada=1;
			
			else if($_GET['g']=='Populares')
				$model->group=$_GET['g'];
				
			else if($_GET['g']=='Novidades')
				$model->group=$_GET['g'];
		}	
		
		if(isset($_GET['c']))
		{
			$model->location=$_GET['c'];
		}
		
		if(isset($_GET['Startup_sort'])/*|| isset($_GET['ajax'])*/)
		{
			//$model->rand=false;
			$model->default_sort=false;
		}
		
			
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
		$model=Startup::model()->find('startupname=:name',
										array(
										  ':name'=>$name,
										));
		if($model===null)
			throw new CHttpException(404,UserModule::t('Page not found.'));
		return $model;
	}
	
	public function loadModelId($id)
	{
		$model=Startup::model()->find('id=:id',
										array(
										  ':id'=>$id,
										));
		if($model===null)
			throw new CHttpException(404,UserModule::t('Page not found.'));
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
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
         
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
				$model->followers_num=$model->followers_num+1;
				$model->saveWithRelated(array('users'));
				
				$activity = new ActivityStartup;
                $activity->user_id = Yii::app()->user->id;
                $activity->activity_type = ActivityStartup::FOLLOW_STARTUP;
                $activity->startup_id = $model->id;
                $activity->save(); 
				
				echo CJSON::encode(array(
					'res'=>count($model->users)
				));
				exit;
			}
			
			else 
			{
				
				if($model->hasUserFollowing(Yii::app()->user->id))
				{
					echo CJSON::encode(array(
						'res'=>count($model->users)
					));
					exit;
				}
				
				$model->users=User::model()->findbyPk(Yii::app()->user->id);
				$model->saveWithRelated( array('users' => array('append' => true)));
				
				$activity = new ActivityStartup;
                $activity->user_id = Yii::app()->user->id;
                $activity->activity_type = ActivityStartup::FOLLOW_STARTUP;
                $activity->startup_id = $model->id;
                $activity->save(); 
				
				$model = $this->loadModel($_GET['name']);
				
				echo CJSON::encode(array(
					'res'=>count($model->users)
				));
				exit;
			}		
		}
		
		else
			throw new CHttpException(404,UserModule::t('Page not found.'));
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
				$model = $this->loadModel($_GET['name']);
				$model->followers_num=$model->followers_num-1;
				if($model->save())
				{
					echo CJSON::encode(array(
						'res'=>count($model->users)
					));
					exit;
				}
			}
			
			echo CJSON::encode(array(
				'res'=>count($model->users)
			));
			exit;
		}
		
		else
			throw new CHttpException(404,UserModule::t('Page not found.'));	
	}
	
	public function actionMultPic($name)
	{
		
		if(isset($_POST['mult_pic']))
		{
		
			$model=$this->loadModel($name);
			if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
				throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
			
			$img_list=CUploadedFile::getInstancesByName('mult_pic');
			
			foreach($img_list as $mult_pic)
			{

				$model->mult_pic=$mult_pic;
				
				if($model->mult_pic !== null && $model->validate())
				{
				
					$fileName=$model->mult_pic;
					$rnd = rand(0,99999999);  // generate random number between 0-99999999
					$extension_array = explode('.', $fileName); //extension of the file
					$extension=end($extension_array);
					$newFileName = md5("{$rnd}-{$fileName}").'.'.$extension;  // random number + file name
								
					$model->mult_pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
					
					$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
					$image->resize(400, 300)->quality(75)->sharpen(20);
					$image->save(); // or $image->save('images/small.jpg');
					
					$model_img=new Image;
					$model_img->name=$newFileName;
					$model_img->extension=$model->mult_pic->type;
					$model_img->size=0;//$model->pic->size;	
					$model_img->save();	

					$model->images=$model_img;
					$model->saveWithRelated(array('images'));
					
					$this->redirect('edit',array(
						'model'=>$this->loadModel($name),
					));
				
				}
				else
					$this->redirect('edit',array(
						'model'=>$this->loadModel($name),
					));
			
			}		
					
		}
		else
			$this->redirect('edit',array(
						'model'=>$this->loadModel($name),
			));
	}
	
	public function actionAddTeam($name)
	{
		$model=$this->loadModel($name);
		
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
		$user_startup = new UserStartup;
		
		$user_startup->user_id = $_POST['user_startup'];
		$user_startup->startup_id = $model->id;
		$user_startup->position = $_POST['position'];    
        $user_startup->approved = 1; 
		
		if(empty($_POST['user_startup']))
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>UserModule::t('Invalid User!')
			));
			exit;
		}
		
		if($user_startup->position!=='Founder' && $user_startup->position!=='Member' && $user_startup->position!=='Advisor' && $user_startup->position!=='Investor')
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>UserModule::t('Define Role!'),
			));
			exit;
		}
		
		if(UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$user_startup->user_id, ':s_id'=>$user_startup->startup_id)))
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>UserModule::t('User already exists!'),
			));
			exit;
		}
		
        if($user_startup->save() && ($user_startup->position!=='Advisor' && $user_startup->position!=='Investor'))
        {		
            $auth = Yii::app()->authManager;
            $auth->assign("StartupMember",$user_startup->user_id);
        }				
			
		
		$model=$this->loadModel($name);
		
	/*	$html_result='';
		
		foreach($model->users1 as $start_users)
		{
			
		}		
	*/

		//$html='<div style="margin:2px;">nh'. $user_startup->position .'</div>';
		$usr=User::model()->findbyPk($user_startup->user_id);

/*		$html='<div class="lala" style="margin-bottom:10px; overflow:auto; display:none;">
			<img src="'. Yii::app()->request->baseUrl .'/images/'. $usr->profile->logo->name .'" id="generic-img" alt="asdasd" style="float:left; width: 60px; height:60px;"/>
			
			<div><span data-id="'. $usr->id .'">'. $usr->profile->firstname . ' ' . $usr->profile->lastname .'</span></div>
			<div>'. $usr->profile->resume . '</div>
			<div>'. $user_startup->position . '<i class="icon-remove-sign"></i></div>
		</div>';
*/		
		$html='
		
		<div class="team-item" style="display:none; opacity:0;">
			<div class="team-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $usr->profile->logo->name .'" id="team-img"/></div>
			<div class="team-text">
				<div class="team-name"><span data-id="'. $usr->id .'">'. $usr->profile->firstname . ' ' . $usr->profile->lastname .'</span></div>
				<div class="team-position">'. UserModule::t($user_startup->position) . '</div>
				<div class="team-resume">'. $usr->profile->resume . '</div>
			</div>
			<div class="team-delete"><i class="icon-remove-sign"></i></div>
			<div class="team-error"></div>
		</div>
		
		';
        
        $note = new Notification;
        $note->user_id = $usr->id;
        $note->notification_type = Notification::ADDED_TO_STARTUP;
        $note->source_id = Yii::app()->user->id;
        $note->target_id = $model->id;
        $note->save();
	
		
		echo CJSON::encode(array(
				'res'=>$html
			));
		exit;
	}
	
	
	public function actionAddPress($name)
	{
		$model=$this->loadModel($name);
		
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
		$press = new Press;
		
		$press->startup_id = $model->id;
		$press->url = $_POST['url'];
		$press->title = $_POST['title'];
		$press->description = $_POST['description'];    
        $press->time = $_POST['date']; 
		
		if(empty($_POST['url']) || empty($_POST['title']) || empty($_POST['description']) || empty($_POST['date']))
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>'Preencha todos os campos!'
			));
			exit;
		}
		
		else
		{	
		
			$press->save();
			
			/* manipulate url */ 
			$url=preg_replace('/http:\/\//', '', $press->url);
			$url=preg_replace('/https:\/\//', '', $url);
			if(strpos($url, '/'))
				$url=strstr($url, '/', true);
		
			$html='
		
			<div class="press-item" style="display:none; opacity:0;">
				<div class="press-text">
					<div class="press-url"><span data-id="'. $press->id .'">'. CHtml::encode($url) .'</span></div>
					<div class="press-title">'. CHtml::link(CHtml::encode($press->title), CHtml::encode($press->url), array('target'=>'_blank')) . '</div>
					<div class="press-description">'. CHtml::encode($press->description) . '</div>
					<div class="press-date">'. date('d/m/y', strtotime(CHtml::encode($press->time))) . '</div>
				</div>
				<div class="press-delete"><i class="icon-remove-sign"></i></div>
				<div class="press-error"></div>
			</div>
			
			';
			
			
			echo CJSON::encode(array(
				'res'=>$html
			));
			exit;
		}
		
	}
	
	public function actionAddTraction($name)
	{
		$model=$this->loadModel($name);
		
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
		$traction = new Traction;
		
		$traction->startup_id = $model->id;
		$traction->metric = $_POST['metric'];
		$traction->value = $_POST['value'];
		$traction->period = $_POST['period'];    
        $traction->date = $_POST['date-traction']; 
		
		if(empty($_POST['metric']) || empty($_POST['value']) || empty($_POST['period']) || empty($_POST['date-traction']))
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>'Preencha todos os campos!'
			));
			exit;
		}
		
		else
		{	
		
			$traction->save();
			
			if(count($model->traction)>1)
				$exist=true;
			else 
			{
				$exist=false;
				$model->completion=$model->completion+10;
				$model->save();
			}
			$html='
		
			<div class="traction-item" style="display:none; opacity:0;">
				<div class="traction-text">
					<table>
						<tr>
							<td><div class="tracion-metric"><span data-id="'. $traction->id .'">'. CHtml::encode($traction->metric) .'</span></div></td>
							<td><div class="traction-value">'. CHtml::encode($traction->value) .'</div></td>
							<td><div class="traction-period">'. CHtml::encode($traction->period) . '</div></td>
							<td><div class="traction-date">'. date('d/m/y', strtotime(CHtml::encode($traction->date))) . '</div></td>
						<tr>
					</table>
				</div>
				<div class="traction-delete"><i class="icon-remove-sign"></i></div>
				<div class="traction-error"></div>
			</div>
			
			';
			
			echo CJSON::encode(array(
				'res'=>$html,
				'exist'=>$exist
			));
			exit;
		}
		
	}
	
	public function actionAddPast($name)
	{
		$model=$this->loadModel($name);
		
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
		$past = new PastInvestment;
		
		$past->startup_id = $model->id;
		
		if(!empty($_POST['past_investor_id']))
			$past->user_id = $_POST['past_investor_id'];
		else
			$past->investor_name = $_POST['past_investor_name'];
			
		$past->value = $_POST['value-past'];  
        $past->date = $_POST['date-past']; 
		
		if((empty($_POST['past_investor_id']) && empty($_POST['past_investor_name'])) || empty($_POST['value-past']) || empty($_POST['date-past']))
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>'Preencha todos os campos!'
			));
			exit;
		}
		
		else
		{	
		
			$past->save();
		
			$html='
		
			<div class="past-item" style="display:none; opacity:0;">
					<table>
						<tr>
							<td>
							';

			if(empty($past->user_id)){
				$html.='<div class="past-image"><img src="'.Yii::app()->request->baseUrl.'/images/default-user.png" id="past-img" /></div>
						<div class="past-investor"><span data-id="'.CHtml::encode($past->id).'">'.CHtml::encode($past->investor_name).'</div>
				';	
			}
			else{
				$usr=User::model()->find('user_id=:u_id', array(':u_id'=>$past->user_id));
				$html.='<div class="past-image">'.CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$usr->profile->logo->name.'" id="past-img" />', array('/' . $usr->username)).'</div>
						<div class="past-investor"><span data-id="'.CHtml::encode($past->id).'">'.CHtml::link(CHtml::encode($usr->getFullName()), array('/' . $usr->username)).'</div>
				';
			}			
			
			$html.='
							</td>
							<td><div class="past-value">'. CHtml::encode($past->value) .'</div></td>
							<td><div class="past-date">'. date('d/m/y', strtotime(CHtml::encode($past->date))) . '</div></td>
						</tr>	
					</table>
				<div class="past-delete"><i class="icon-remove-sign"></i></div>
				<div class="past-error"></div>
			</div>
			
			';
		
			
			echo CJSON::encode(array(
				'res'=>$html
			));
			exit;
		}
		
	}
	
	
	public function actionDeleteTeam($id, $name)
	{
		$model=$this->loadModel($name);
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
			
		if(UserStartup::model()->find('startup_id=:s_id AND user_id=:u_id', array(':s_id'=>$model->id, ':u_id'=>$id))->position=="Founder" && count(UserStartup::model()->findAll('startup_id=:s_id AND position="Founder"', array(':s_id'=>$model->id)))<=1)	
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>UserModule::t("You cannot delete this Founder!")
			));
			exit;
		}
		
		$user_startup=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$id, ':s_id'=>$model->id));
		$user_startup->delete();
			
		echo CJSON::encode(array(
				'res'=>'OK'
			));
		exit;
	}
	
	public function actionDeletePress($id, $name)
	{
		$model=$this->loadModel($name);
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
		$press=Press::model()->find('id=:p_id AND startup_id=:s_id', array(':p_id'=>$id, ':s_id'=>$model->id));
		$press->delete();
			
		echo CJSON::encode(array(
				'res'=>'OK'
			));
		exit;
	}
	
	public function actionDeleteTraction($id, $name)
	{
		$model=$this->loadModel($name);
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
		$traction=Traction::model()->find('id=:t_id AND startup_id=:s_id', array(':t_id'=>$id, ':s_id'=>$model->id));
		$traction->delete();
			
		if(count($model->traction)==0)
		{	
			$exist=false;
			$model->completion=$model->completion-10;
			$model->save();
		}
		else 
			$exist=true;
		
		echo CJSON::encode(array(
				'res'=>'OK',
				'exist'=>$exist
			));
		exit;
	}
	
	public function actionDeletePast($id, $name)
	{
		$model=$this->loadModel($name);
		if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
		
		$past=PastInvestment::model()->find('id=:p_id AND startup_id=:s_id', array(':p_id'=>$id, ':s_id'=>$model->id));
		$past->delete();
			
		echo CJSON::encode(array(
				'res'=>'OK'
			));
		exit;
	}
    
    public function actionApprove($uid, $sid)
    {
        $startup = Startup::model()->findByPk($sid);
        if(!$startup->hasUserRelation())
            throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
        
        $user_startup=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$uid, ':s_id'=>$sid));
		$user_startup->approved=1;
        if($user_startup->save())
        {		
            $auth = Yii::app()->authManager;
            $auth->assign("StartupMember",$user_startup->user_id);
            
            $html='
		
            <div class="team-item" style="display:none; opacity:0;">
                <div class="team-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $user_startup->user->profile->logo->name .'" id="team-img"/></div>
                <div class="team-text">
                    <div class="team-name"><span data-id="'. $user_startup->user_id .'">'. $user_startup->user->getFullName() .'</span></div>
                    <div class="team-position">'. UserModule::t($user_startup->position) . '</div>
                    <div class="team-resume">'. $user_startup->user->profile->resume . '</div>
                </div>
                <div class="team-delete"><i class="icon-remove-sign"></i></div>
            </div>

            ';

            echo CJSON::encode(array(
                    'res'=>$html
                ));
            exit;
        }	
    }
	
	public function actionMultUp($name)
	{
		  
		 
		$model=$this->loadModel($name);
	
		if(count($model->images)>=4)
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>'<span style="color:red;">Limite atingido!</span>'
			));
			exit;
		}
    
		else if(isset($_POST)){
			$nome_imagem    = $_FILES['imagem']['name'];
			$tamanho_imagem = $_FILES['imagem']['size'];
			
			
			$rnd = rand(0,99999999);  // generate random number between 0-99999999
			$extension_array = explode('.', $nome_imagem); //extension of the file
			$extension=end($extension_array);
			$newFileName = md5("{$rnd}-{$nome_imagem}").'.'.$extension;  // random number + file name
			
			$tmp = $_FILES['imagem']['tmp_name']; 
			
			//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! testes
			
			$model->pic=CUploadedFile::getInstanceByName('imagem');
			if(!$model->validate())
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>'<span style="color:red;">'. $model->getErrors('pic')[0] .'</span>'
			));
			exit;
		}
		//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! fim dos testes
		
			  
			move_uploaded_file($tmp,Yii::getPathOfAlias('webroot').'/images/'.$newFileName); 
			

			
			$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
			
			if($image->width>=$image->height)
				{
					$image->resize(500, 312, ImageExt::WIDTH)->quality(75)->sharpen(20);
				}
				else
					$image->resize(500, 312, ImageExt::HEIGHT)->quality(75)->sharpen(20);
				
				$image->save(); // or $image->save('images/small.jpg');
			
					
					$model_img=new Image;
					$model_img->name=$newFileName;
					$model_img->extension=$extension;
					$model_img->size=0;//$model->pic->size;	
					$model_img->save();	

					$model->images=$model_img;
					$model->saveWithRelated(array('images' => array('append' => true)));	
 
         
        
                    //echo "<img src='".Yii::app()->request->baseUrl.'/images/'.$newFileName."' id='previsualizar'>"; //imprime a foto na tela
					
					//$html="<img src='".Yii::app()->request->baseUrl.'/images/'.$newFileName."' data-name='".$newFileName."' class='mult-list-img' style='float:left; width: 100px; height:100px; margin:0 20px 20px 0; opacity:0;' data-toggle='tooltip' data-html=true data-original-title='clique para deletar' >";
	
					$html="<div class='mult-list-img-wrap' data-name='".$newFileName."' style='float:left; width: 100px; height:80px; line-height:80px; text-align:center; margin:0 20px 20px 0; background: #f6f6f6; border-radius: 3px;' data-toggle='tooltip' data-html=true data-original-title='clique para deletar'>
								<img src='".Yii::app()->request->baseUrl.'/images/'.$newFileName."' class='mult-list-img' style='max-width: 100px; max-height:63px;'/>
						   </div>";
		
					
					if(count($model->images)==1)
					{
						$exist=false;
						$model->completion=$model->completion+4;
						$model->save();
					}
					else
						$exist=true;
					
					echo CJSON::encode(array(
							'res'=>$html,
							'exist'=>$exist
						));
             
            exit;
        
		}
	}

	
	public function actionLogoUp($name)
	{
		$model=$this->loadModel($name);
    
		if(isset($_POST)){
			$nome_imagem    = $_FILES['imagem-2']['name'];
			$tamanho_imagem = $_FILES['imagem-2']['size'];
			$tmp = $_FILES['imagem-2']['tmp_name'];
			
			if($model->logo==1)
			{	
		
				$rnd = rand(0,99999999);  // generate random number between 0-99999999
				$extension_array = explode('.', $nome_imagem); //extension of the file
				$extension=end($extension_array);
				$newFileName = md5("{$rnd}-{$nome_imagem}").'.'.$extension;  // random number + file name 
				
				//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! testes
				
				$model->pic=CUploadedFile::getInstanceByName('imagem-2');
				if(!$model->validate())
				{
					echo CJSON::encode(array(
						'res'=>'no',
						'msg'=>'<span style="color:red;">'. $model->getErrors('pic')[0] .'</span>'
					));
					exit;
				}
				
				//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! fim dos testes
			
				  
				move_uploaded_file($tmp,Yii::getPathOfAlias('webroot').'/images/'.$newFileName); 
					
				$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
				
				if($image->width>=$image->height)
				{
					$image->resize(500, 312, ImageExt::WIDTH)->quality(75)->sharpen(20);
				}
				else
					$image->resize(500, 312, ImageExt::HEIGHT)->quality(75)->sharpen(20);
					
				$image->save(); // or $image->save('images/small.jpg');
				
						
				$model_img=new Image;
				$model_img->name=$newFileName;
				$model_img->extension=$extension;
				$model_img->size=0;//$model->pic->size;	
				if($model_img->save()){
					$model->logo=$model_img->id;
					$model->save();
				}
				
				echo CJSON::encode(array(
							'res'=>'OK',
				));
             
				exit;
			}
			
			else
			{
				
				//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! testes
				
		/*		$model->pic=CUploadedFile::getInstanceByName('imagem-2');
				if(!$model->validate())
				{
					echo CJSON::encode(array(
						'res'=>'no',
						'msg'=>'<span style="color:red;">'. $model->getErrors('pic')[0] .'</span>'
					));
					exit;
				}
		*/		
				//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! fim dos testes
				
				unlink(Yii::getPathOfAlias('webroot').'/images/'.$model->logo0->name);
					
				$img=Image::model()->findByPk($model->logo);
				$ext_arr = explode('.', $img->name);
				$ext = end($ext_arr);
				$new_name=md5($img->name).'.'.$ext;
					
				$img->name=$new_name;
					
				$img->save();
					
				move_uploaded_file($tmp,Yii::getPathOfAlias('webroot').'/images/'.$img->name);
					
				$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$img->name);
					
				if($image->width>=$image->height)
				{
					$image->resize(120, 120, ImageExt::WIDTH)->sharpen(25);
				}
				else
					$image->resize(120, 120, ImageExt::HEIGHT)->sharpen(25);
					
				$image->save(); // or $image->save('images/small.jpg');
				
				echo CJSON::encode(array(
							'res'=>'OK',
				));
             
				exit;
			}
        
		}
		
	}
	
	
	public function actionMultDel($name, $imgname)
	{
		$model=$this->loadModel($name);
		
		unlink(Yii::getPathOfAlias('webroot').'/images/'.$imgname);
		
		$img=Image::model()->find('name=:name', array(':name'=>$imgname));
		$img->delete();
		
		if(count($model->images)==0)
		{
			$exist=true;
			$model->completion=$model->completion-4;
			$model->save();
		}
		else
			$exist=false;
		
		echo CJSON::encode(array(
			'exist'=>$exist
		));
		
		exit;
		
	}	
	
	public function actionAutoTest()
	{
		if(!empty($_GET['term']))
		{
			$param = addcslashes($_GET['term'], '%_'); // escape LIKE's special characters
			$qry = new CDbCriteria( array(
				'condition' => "firstname LIKE :param OR lastname LIKE :param OR CONCAT(firstname, ' ' , lastname) LIKE :param",         // no quotes around :match
				'params'    => array(':param' => "%$param%"),  // Aha! Wildcards go here
				'limit'=>5
			) );
			
			$query = Profile::model()->findAll($qry);     // works!
		}
		else
			$query = null;
		
		
		$list = array();        
		foreach($query as $q){
			$data['value'] = $q->user_id;
			
			if(isset($q->user->roles) && isset($q->city))
				$data['description'] = $q->user->roles[0]->name .' · '. $q->city->nome;
			else
				$data['description'] = '';
				
			$data['label'] = $q->firstname .' '. $q->lastname;
			$data['image'] = $q->logo->name;

			$list['myData'][] = $data;
			unset($data);
		}
		
		if(!empty($query))
			echo json_encode($list);
		
		else 
			throw new CHttpException(403,UserModule::t('You cannot edit this Startup!'));
			
	}
	
	public function actionPressUrl()
	{
		$url=$_GET['term'];
		include_once("inc/simple_html_dom.php");
			
		//get URL content
		$get_content = file_get_html($url); 
			
		//Get Page Title 
        foreach($get_content->find('title') as $element) 
        {
            $page_title = $element->plaintext;
        }
		
		//prepare for JSON 
        $output = array('title'=>$page_title);
        echo json_encode($output); //output JSON data
	}
	
	public function actionRefreshStartupName($id)
	{
		$model=$this->loadModelId($id);
		
		echo CJSON::encode(array(
			'res'=>$model->startupname
		));
	}
				
	public function actionFollowPop($id)
	{
		$model = $this->loadModelId($id);
		EQuickDlgs::render('_followpop',array('provider'=>$model->users));
	
	}
					
	
}
