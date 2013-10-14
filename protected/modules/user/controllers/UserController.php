<?php

class UserController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

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
            array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view', 'follow', 'unfollow'),
				'users'=>array('@'),
			),
            array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        /*
        if(Yii::app()->user->isGuest){
            $user = Yii::app()->getComponent('user');
            $user->setFlash(
                'error',
                '<strong>Ops!</strong> Você precisa estar conectado apra acessar essa área.'
            );
            $this->redirect(Yii::app()->controller->module->loginUrl);
        }
		$model=new Profile('search');
		$model->unsetAttributes();  // clear any default values
                
		if(isset($_GET['n'])) {
            $model->fullname=$_GET['n'];
			$model->resume=$_GET['n'];
		}
		
		if(isset($_GET['rol']))
			$model->roles=$_GET['rol'];	
				
        if(isset($_GET['g']))
		{
			if($_GET['g']=='Mais seguidos')
				$model->group=$_GET['g'];
		}	
        
		$this->render('index',array(
            'dataProvider'=>$model,
        ));
         * 
         */
	}
    
    public function actionFollow()
	{   
        $model = $this->loadModel($_GET['username']);
        
        if(!Yii::app()->user->checkAccess('followUser', array('userid'=>$model->id)))
            throw new CHttpException(403, 'You cannot perform this action.');
        
		if(Yii::app()->request->isAjaxRequest)
		{	
			if(!$model->followers)
			{
				$model->followers=new UserFollow;                
                $model->followers->follower_id = Yii::app()->user->id;
                $model->followers->followed_id = $model->id;                
				$model->followers->save();
                echo CJSON::encode(array(
					'res'=>count($model->followers)
				));
				exit;
			}			
			else 
			{
				if($model->hasUserFollowing(Yii::app()->user->id))
				{
					echo CJSON::encode(array(
						'res'=>count($model->followers)
					));
					exit;
				}				
				$model->followers=new UserFollow;                
                $model->followers->follower_id = Yii::app()->user->id;
                $model->followers->followed_id = $model->id;
				$model->followers->save();
                $model = $this->loadModel($_GET['username']);
				echo CJSON::encode(array(
					'res'=>count($model->followers)
				));
				exit;
			}		
		}
		
		else
			throw new CHttpException(404, 'Page not found.');
	}
	
	public function actionUnfollow()
	{
        $model = $this->loadModel($_GET['username']);
        
        if(!Yii::app()->user->checkAccess('followUser', array('userid'=>$model->id)))
            throw new CHttpException(403, 'You cannot perform this action.');
        
		if(Yii::app()->request->isAjaxRequest )
		{			
			if ($model->hasUserFollowing(Yii::app()->user->id))
			{
				$user_follow=UserFollow::model()->find('follower_id=:u_id AND followed_id=:s_id', array(':u_id'=>Yii::app()->user->id, ':s_id'=>$model->id));
				$user_follow->delete();
                $model = $this->loadModel($_GET['username']);
				echo CJSON::encode(array(
                    'res'=>count($model->followers)
                ));
                exit;
			}			
			echo CJSON::encode(array(
				'res'=>count($model->followers)
			));
			exit;
		}
		
		else
			throw new CHttpException(404, 'Page not found.');	
	}
    
    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	//load User from username
    public function loadModel($username)
	{
		$model=User::model()->find('username=:username',
										array(
										  ':username'=>$username,
										));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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
