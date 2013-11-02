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
				'actions'=>array('create', 'edit', 'follow', 'unfollow'/* tinha parado aqui... o resto veio do * acima*/,'editsectors', 'updateName', 'multPic', 'addTeam', 'deleteTeam', 'publish'),
				'users'=>array('@'),
			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update', 'updatelocation', 'updateSectors'),
				'users'=>array('@'),
                'verbs'=>array('POST'),
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
		$model=$this->loadModel($name);
		
		if($model->published==1)
		{
			$this->render('view',array(
			'model'=>$model,
			));
		}
		
		else
		{
			 if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
				throw new CHttpException(404, 'Page not found.');
			
			else
				$this->redirect(array('publish','name'=>$model->startupname));
		}
	}
	
	public function actionPublish($name)
	{
		$model=$this->loadModel($name);
       
        if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,'Você não pode editar essa startup!');
		
		if(!$model->sectors || !$model->product_description)
		{
			$alert_sectors=empty($model->sectors)?'<li>Setor(es)</li>':'';
			$alert_product=empty($model->product_description)?'<li>Produto</li>':'';
			
			$user = Yii::app()->getComponent('user');
            $user->setFlash(
                'error',
                '<strong>Atenção!</strong> Para publicar o perfil, preencha no mínimo os campos listados a seguir:<p><ul>'.$alert_product.$alert_sectors.'</ul></p>'
            );
			$this->redirect(array('edit','name'=>$model->startupname));
		}

		else
		{
			$model->published=1;
			
			if($model->save())
				$this->redirect(array('view','name'=>$model->startupname));
			
			else
			{
				$user = Yii::app()->getComponent('user');
				$user->setFlash(
					'error',
					'<strong>Ops!</strong> Ocorreu algum erro. Tente novamente.'
				);
				$this->redirect(array('edit','name'=>$model->startupname));		
			}
		}	 

	}
	
	public function actionEdit($name)
	{
        $model=$this->loadModel($name);
       
        if(!Yii::app()->user->checkAccess('editStartup', array('startup'=>$model)))
            throw new CHttpException(403,'Você não pode editar essa startup!');
		
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
					$image->resize(400, 300)->quality(75)->sharpen(20);
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
					$image->resize(400, 300)->quality(75)->sharpen(20);
					$image->save(); // or $image->save('images/small.jpg');
					
					$this->refresh();
				}
			}
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
			$user = Yii::app()->getComponent('user');
            $user->setFlash(
                'warning',
                '<strong>MODO RASCUNHO</strong><br/><br/>Para publicar o perfil, preencha no mínimo os campos "Setor(es)" e "Produto" e clique no botão \'Publicar\'.'
            );
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
			$model->attributes=$_POST['Startup'];
			$model->name = preg_replace('/[\/%><=#\$]/', '', $model->name);
			
			// !!!!!!!!!!!! formatting startup name !!!!!!!!!!!!!!!!!!
			$startupname = $_POST['Startup']['name'];
			$startupname = preg_replace('/[\/\&%><=#\$]/', '', $startupname);
			$startupname = preg_replace('/[\"\']/', '', $startupname);
			$startupname = preg_replace('/\s+/', '-', strtolower($startupname));
			
			
			$model->startupname = $startupname; 
			
			// !!!!!!!!!!!! end formatting startupname !!!!!!!!!!!!!!!
			
			
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
					$image->resize(120, 120, ImageExt::WIDTH)->quality(75)->sharpen(20);
				}
				else
					$image->resize(120, 120, ImageExt::HEIGHT)->quality(75)->sharpen(20);
				
				$image->save(); // or $image->save('images/small.jpg');
				
				$model_img=new Image;
				$model_img->name=$newFileName;
				$model_img->extension=$model->pic->type;
				$model_img->size=0;//$model->pic->size;		
			
			
				if($model_img->save()){
					$model->logo=$model_img->id;
				}
				
				else 
					$model->logo=null;
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
                
                if($user_startup->save())
                {		
                    $auth = Yii::app()->authManager;
                    $auth->assign("StartupOwner",Yii::app()->user->id);
                    $this->redirect(array('edit','name'=>$model->startupname));
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
            throw new CHttpException(403,'Você não pode editar esse projeto!');
        
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

	public function actionUpdateName()
    {
		$model = $this->loadModelId($_POST['pk']);
		$model->name = $_POST['value'];
		if($model->validate())$model->save(); 
		
		
		
	}
	
	public function actionUpdateLocation()
    {
        $model = $this->loadModelId($_POST['pk']);
        if($_POST['value']==0) $model->location=NULL;
        else $model->location = $_POST['value'];
        $model->save();         
    }
	
	
	public function actionUpdateSectors()
    {
        $model = $this->loadModelId($_POST['pk']);
        $vals = array();
        if(isset($_POST['value']))
        {
            foreach ($_POST['value'] as $val)
            {
                $vals[] = Sector::model()->find('sector_id=:id', array(':id'=>$val));
            }
        }
		
		if(count($vals)>3)
			exit;
			
        $model->sectors = $vals;
        $model->saveWithRelated(array('sectors'));            
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
			$this->loadModelId($id)->delete();

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
			$model->name=strip_tags($_GET['n']);
			$model->one_line_pitch=strip_tags($_GET['n']);
		}
		if(isset($_GET['c_stage']))
			$model->company_stage=$_GET['c_stage'];	
		
		if(isset($_GET['sec']))
			$model->sectors=$_GET['sec'];	
			
		if(isset($_GET['g']))
		{
			if($_GET['g']=='Selecionadas')
				$model->selecionada=1;
			
			else if($_GET['g']=='Populares')
				$model->group=$_GET['g'];
				
			else if($_GET['g']=='Novidades')
				$model->group=$_GET['g'];
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
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function loadModelId($id)
	{
		$model=Startup::model()->find('id=:id',
										array(
										  ':id'=>$id,
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
				$model->followers_num=$model->followers_num+1;
				$model->saveWithRelated(array('users'));
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
				$model->followers_num=$model->followers_num+1;
				$model->saveWithRelated( array('users' => array('append' => true)));
				echo CJSON::encode(array(
					'res'=>count($model->users)
				));
				exit;
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
			throw new CHttpException(404, 'Page not found.');	
	}
	
	public function actionMultPic($name)
	{
		
		if(isset($_POST['mult_pic']))
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
            throw new CHttpException(403,'Você não pode editar essa startup!');
		
		$user_startup = new UserStartup;
		
		$user_startup->user_id = $_POST['user_startup'];
		$user_startup->startup_id = $model->id;
		$user_startup->position = $_POST['position'];    
        if($user_startup->save())
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
			<div class="team-name"><span data-id="'. $usr->id .'">'. $usr->profile->firstname . ' ' . $usr->profile->lastname .'</span></div>
			<div class="team-position">'. $user_startup->position . '</div>
			<div class="team-resume">'. $usr->profile->resume . '</div>
			<div class="team-delete"><i class="icon-remove-sign"></i></div>
		</div>
		
		';
	
		
		echo CJSON::encode(array(
				'res'=>$html
			));
		exit;
	}
	
	
	public function actionDeleteTeam($id, $name)
	{
		$model=$this->loadModel($name);
		$user_startup=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$id, ':s_id'=>$model->id));
		$user_startup->delete();
			
		echo CJSON::encode(array(
				'res'=>'OK'
			));
		exit;
	}
	
	
	
	
	
}
