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
				'actions'=>array('index','view', 'follow', 'unfollow', 'investors'),
				'users'=>array('@'),
			),
            array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Profile('search');
		$model->unsetAttributes();  // clear any default values
        
        $model->special_condition = 't.user_id!='.Yii::app()->user->id;
        
		if(isset($_GET['n'])) {
            $model->fullname=$_GET['n'];
			$model->resume=$_GET['n'];
		}
		
		if(isset($_GET['sec']))
			$model->roles=$_GET['sec'];	
				
        if(isset($_GET['g']))
		{
			if($_GET['g']=='Mais seguidos')
				$model->group=$_GET['g'];
		}	
        
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
    
    public function actionFollow()
	{   
        if($_GET['username'] === Yii::app()->user->id)
            throw new CHttpException(403, 'You cannot perform this action.');
        
		if(Yii::app()->request->isAjaxRequest)
		{
			$model = $this->loadModel($_GET['username']);            
			
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
		if(Yii::app()->request->isAjaxRequest )
		{
			$model = $this->loadModel($_GET['username']);
			
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
}
