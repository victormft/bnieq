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
				'actions'=>array('profile'),
				'users'=>array('*'),
			),
            array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('edit', 'startupsforportfolio', 'logoUp'),
				'users'=>array('@'),
			),
            array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('updateed', 'updatelocation', 'updateroles', 'updateskills', 'updatesectors', 'updatestartuprelational', 'addstartuprelation', 'toggle', 'report', 'sortable'),
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
	public function actionProfile()
	{
        if(Yii::app()->user->isGuest){
            $user = Yii::app()->getComponent('user');
            $user->setFlash(
                'error',
                '<strong>Ops!</strong> Você precisa estar conectado apra acessar essa área.'
            );
            $this->redirect(Yii::app()->controller->module->loginUrl);
        }
        
        if(!isset($_GET['username']))
        {
            $model=$this->loadUser(Yii::app()->user->id);
        }
        else            
            $model = $this->loadModel($_GET['username']);
        
	    $this->render('profile',array(
            'model'=>$model,
            'profile'=>$model->profile,
	    ));
	}
    
    public function actionEdit($username)
	{	        
		$model = $this->loadModel($username);
        if(!Yii::app()->user->checkAccess('updateSelf', array('userid'=>$model->id)))
            throw new CHttpException(403, 'You cannot edit this profile.');	
        $profile = $model->profile;  
        
        $stupsForPort=new UserStartup('search');
        $stupsForPort->unsetAttributes();
        $stupsForPort->user_id=$model->id;
        
        
        if(isset($_POST['Profile']['pic']))
		{			
			$profile->pic=CUploadedFile::getInstance($profile,'pic');
			
			if($profile->pic !== null && $profile->validate())
			{			
				if($profile->profile_picture==2)
				{
					$fileName=$profile->pic;
					$rnd = rand(0,99999999);  // generate random number between 0-99999999
					$extension_array = explode('.', $fileName); //extension of the file
					$extension=end($extension_array);
					$newFileName = md5("{$rnd}-{$fileName}").'.'.$extension;  // random number + file name
							
                    //saves the image in the server
					$profile->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);

                    $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
                    
                    if($image->width>=$image->height)
                    {
                        $image->resize(120, 120, ImageExt::WIDTH)->sharpen(25);
                    }
                    else
                        $image->resize(120, 120, ImageExt::HEIGHT)->sharpen(25);
                    
                    //NOT WORKINNNNNG
                    //$image->save(); // or $image->save('images/small.jpg');
                    
                    
                    include('s3_config.php');
                    $s3->putObjectFile(Yii::getPathOfAlias('webroot').'/images/'.$newFileName, S3::BUCKET_NB , $newFileName, S3::ACL_PUBLIC_READ);
                    
                    //deletes from the server
                    unlink(Yii::getPathOfAlias('webroot').'/images/'.$newFileName);
                    //$image->save(); // or $image->save('images/small.jpg');
                    
                    
                    $model_img=new Image;
					$model_img->name=$newFileName;
					$model_img->extension=$profile->pic->type;
					$model_img->size=0;//$profile->pic->size;	
				
				
					if($model_img->save()){
						$profile->profile_picture=$model_img->id;
					}
					
					if($profile->save())
					{
                        $this->refresh();
						/*$this->render('edit',array(
                            'model'=>$model,
                            'profile'=>$profile,
                        ));
                         * 
                         */
					}
				}
				else
				{
					//unlink(Yii::getPathOfAlias('webroot').'/images/'.$profile->logo->name);
					
                    include('s3_config.php');
                    $s3->deleteObject(S3::BUCKET_NB, $profile->logo->name);
                    
					$img=Image::model()->findByPk($profile->profile_picture);
					$ext_arr = explode('.', $img->name);
					$ext = end($ext_arr);
					$new_name=md5($img->name).'.'.$ext;
					
					$img->name=$new_name;
                    
                    //saves the model
					$img->save();
					
                    //saves in the server
                    $profile->pic->saveAs(Yii::getPathOfAlias('webroot').'/images/'.$img->name);
                                        
                    
					$image = Yii::app()->image->load(Yii::getPathOfAlias('webroot').'/images/'.$img->name);
					if($image->width>=$image->height)
					{
						$image->resize(120, 120, ImageExt::WIDTH)->sharpen(25);
					}
					else
						$image->resize(120, 120, ImageExt::HEIGHT)->sharpen(25);
					
                    //NOT WORKINNNNNG
                    //$image->save(); // or $image->save('images/small.jpg');
                    
                    //saves in aws
                    $s3->putObjectFile(Yii::getPathOfAlias('webroot').'/images/'.$img->name, S3::BUCKET_NB , $new_name, S3::ACL_PUBLIC_READ);
					
                    //deletes from the server
                    unlink(Yii::getPathOfAlias('webroot').'/images/'.$img->name);
                    
					$this->refresh();
				}
			}
		}
		$this->render('edit',array(
            'model'=>$model,
            'profile'=>$profile,
            'stupsForPort'=>$stupsForPort,
		));
	}
    
    public function actionLogoUp($username)
	{               
		$model=$this->loadModel($username);
        $profile = $model->profile;
        
		if(isset($_POST)){
			$nome_imagem    = $_FILES['imagem-2']['name'];
			$tamanho_imagem = $_FILES['imagem-2']['size'];
			$tmp = $_FILES['imagem-2']['tmp_name'];
			
			if($profile->profile_picture==2)
			{			
				$rnd = rand(0,99999999);  // generate random number between 0-99999999
				$extension_array = explode('.', $nome_imagem); //extension of the file
				$extension=end($extension_array);
				$newFileName = md5("{$rnd}-{$nome_imagem}").'.'.$extension;  // random number + file name 
				
				//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! testes
				
				$profile->pic=CUploadedFile::getInstanceByName('imagem-2');                
				if(!$profile->validate())
				{
					echo CJSON::encode(array(
						'res'=>'no',
						'msg'=>'<span style="color:red;">'. $profile->getErrors('pic')[0] .'</span>'
					));
					exit;
				}
                
                $model_img=new Image;
				$model_img->name=$newFileName;
				$model_img->extension=$extension;
				$model_img->size=0;//$model->pic->size;	
				if($model_img->save()){
					$profile->profile_picture=$model_img->id;
					$profile->save();
				}
                
                $src=imagecreatefromjpeg($tmp);
				
				list($width,$height)=getimagesize($tmp);
				
				if($width>=$height)
				{
					$newwidth=200;
					$newheight=($height/$width)*$newwidth;
					$new_tmp=imagecreatetruecolor($newwidth,$newheight);
				}
				else
				{
					$newheight=200;
					$newwidth=($width/$height)*$newheight;
					$new_tmp=imagecreatetruecolor($newwidth,$newheight);
				}			
                
                
				imagecopyresampled($new_tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
				
				imagejpeg($new_tmp,Yii::getPathOfAlias('webroot').'/images/'.$model_img->name,75);
                
				include('s3_config.php');
				$s3->putObjectFile(Yii::getPathOfAlias('webroot').'/images/'.$model_img->name, S3::BUCKET_NB , $newFileName, S3::ACL_PUBLIC_READ);
                
				
				//deletes from the server
				unlink(Yii::getPathOfAlias('webroot').'/images/'.$model_img->name);	
                
				
				echo CJSON::encode(array(
                    'res'=>'OK',
				));
             
				exit;
			}
			
			else
			{
				
				//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! testes
				
				$profile->pic=CUploadedFile::getInstanceByName('imagem-2');
				if(!$profile->validate())
				{
					echo CJSON::encode(array(
						'res'=>'no',
						'msg'=>'<span style="color:red;">'. $profile->getErrors('pic')[0] .'</span>'
					));
					exit;
				}
			
				//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! fim dos testes
				
                
				include('s3_config.php');
                $s3->deleteObject(S3::BUCKET_NB, $profile->logo->name);
                
				//unlink(Yii::getPathOfAlias('webroot').'/images/'.$profile->logo->name);
					
				$img=Image::model()->findByPk($profile->profile_picture);
				$ext_arr = explode('.', $img->name);
				$ext = end($ext_arr);
				$new_name=md5($img->name).'.'.$ext;
					
				$img->name=$new_name;
					
				$img->save();
					                
                $src=imagecreatefromjpeg($tmp);
				
				list($width,$height)=getimagesize($tmp);
				
				if($width>=$height)
				{
					$newwidth=200;
					$newheight=($height/$width)*$newwidth;
					$new_tmp=imagecreatetruecolor($newwidth,$newheight);
				}
				else
				{
					$newheight=200;
					$newwidth=($width/$height)*$newheight;
					$new_tmp=imagecreatetruecolor($newwidth,$newheight);
				}
				
				imagecopyresampled($new_tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
				
				imagejpeg($new_tmp,Yii::getPathOfAlias('webroot').'/images/'.$img->name,75);
				
				$s3->putObjectFile(Yii::getPathOfAlias('webroot').'/images/'.$img->name, S3::BUCKET_NB , $new_name, S3::ACL_PUBLIC_READ);
				
                unlink(Yii::getPathOfAlias('webroot').'/images/'.$img->name);
				
                
				echo CJSON::encode(array(
                    'res'=>'OK',
				));
             
				exit;
			}
        
		}
		
	}
        
    public function actionUpdateLocation()
    {        
        $model = $this->loadUser($_POST['pk']);
        if(!Yii::app()->user->checkAccess('updateSelf', array('userid'=>$_POST['pk'])))
            throw new CHttpException(403, 'You cannot edit this profile.');
        
        $profile = $model->profile;
        if($_POST['value']==0) $profile->location=NULL;
        else $profile->location = $_POST['value'];
        $profile->save();         
    }
    
    public function actionUpdateRoles()
    {        
        $model = $this->loadUser($_POST['pk']);
        if(!Yii::app()->user->checkAccess('updateSelf', array('userid'=>$_POST['pk'])))
            throw new CHttpException(403, 'You cannot edit this profile.');
        
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
        if(!Yii::app()->user->checkAccess('updateSelf', array('userid'=>$_POST['pk'])))
            throw new CHttpException(403, 'You cannot edit this profile.');
        
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
        if(!Yii::app()->user->checkAccess('updateSelf', array('userid'=>$_POST['pk'])))
            throw new CHttpException(403, 'You cannot edit this profile.');
        
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
        if(!Yii::app()->user->checkAccess('updateSelf', array('userid'=>$_POST['pk'])))
            throw new CHttpException(403, 'You cannot edit this profile.');
        
        $es = new TbEditableSaver('Profile');  //'Profile' is name of model to be updated        
        $es->update();
    }
    
    public function actionUpdateStartupRelational()
    {        
        $es = new TbEditableSaver('UserStartup');  //'Profile' is name of model to be updated        
        $es->update();
    }
    
    public function actions()
    {
        return array(
            'toggle' => array(
                'class'     =>'bootstrap.actions.TbToggle2Action',
                'modelName' => 'UserStartup',
            ),
            'sortable' => array(
                'class'     => 'bootstrap.actions.TbSortableAction2',
                'modelName' => 'UserStartup'
            )
        );
    }
    
    public function actionAddStartupRelation()
    {		        
		$user_startup = new UserStartup;
		
		$user_startup->user_id = Yii::app()->user->id;
		$user_startup->startup_id = $_POST['startup'];
		$user_startup->position = $_POST['position'];    
        if($user_startup->saveSort())
        {
            $founders = Startup::model()->findbypk($_POST['startup'])->getUsersByRole("Founder");
            foreach ($founders as $founder)
            {
                $note = new Notification;
                $note->user_id = $founder->id;
                $note->notification_type = Notification::ASK_MEMBERSHIP_STARTUP;
                $note->source_id = Yii::app()->user->id;
                $note->target_id = $_POST['startup'];
                $note->save();
            }
        }
        else{
            throw new CHttpException(403, 'Você não pode realizar essa ação.');
            exit;
        }
        
        //$this->redirect($this->createUrl('profile/edit/username/'.Yii::app()->user->getUsername()));
    }
    
    public function actionStartupsForPortfolio()
	{
        if(!empty($_GET['term']))
		{
			$param = addcslashes($_GET['term'], '%_'); // escape LIKE's special characters
			$qry = new CDbCriteria( array(
				'condition' => "name LIKE :param",         // no quotes around :match
				'params'    => array(':param' => "%$param%")  // Aha! Wildcards go here
			) );
			
			$query = Startup::model()->findAll($qry);     // works!
		}
		else
			$query = null;
        
		$list = array();        
		foreach($query as $q){
            if(!$q->hasUserRelation()){
                $data['value'] = $q->id;
                //$data['description'] = $q->profile->resume;
                $data['label'] = $q->name;
                $data['image'] = $q->logo0->name;

                $list['myData'][] = $data;
                unset($data);
            }
		}

		if(!empty($list))
			echo json_encode($list);
		
		else 
			throw new CHttpException(403,'Você não pode editar essa startup!');
	}
    
    public function actionReport()
    {
        $rep=new Report;
        if(isset($_POST['Report']))
        {            
            $rep->target_type=Report::USER;
            $rep->target_id=$_POST['Report']['target_id'];
            $rep->user_id=Yii::app()->user->id;
            $rep->text=$_POST['Report']['text'];
            if($rep->save())
            {
                $user = Yii::app()->getComponent('user');
                $user->setFlash(
                    'success',
                    '<strong>Obrigado!</strong> Seu report foi salvo com sucesso.'
                );                
                $this->redirect(Yii::app()->request->urlReferrer);
            }
        }
        
        
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
    
}