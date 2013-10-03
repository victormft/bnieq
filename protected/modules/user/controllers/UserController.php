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
				'actions'=>array('index','view'),
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

		if(isset($_GET['n'])) {
			$model->name=$_GET['n'];
			$model->one_line_pitch=$_GET['n'];
		}
		if(isset($_GET['c_size']))
			$model->company_size=$_GET['c_size'];	
		
		if(isset($_GET['sec']))
			$model->sectors=$_GET['sec'];	
			
		
        
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
		if(Yii::app()->request->isAjaxRequest )
		{
			$model = $this->loadModel($_GET['username']);            
			
			if(!$model->followers)
			{
				$model->followers=new UserFollow;                
                $model->followers->follower_id = Yii::app()->user->id;
                $model->followers->followed_id = $model->id;                
				$model->followers->save();
				return count($model->followers);
			}			
			else 
			{
				if($model->hasUserFollowing(Yii::app()->user->id))
				{
					return count($model->followers);
				}				
				$model->followers=new UserFollow;                
                $model->followers->follower_id = Yii::app()->user->id;
                $model->followers->followed_id = $model->id;
				$model->followers->save();
				return count($model->followers);
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
				return count($model->followers);
			}
			
			return count($model->followers);
		}
		
		else
			throw new CHttpException(404, 'Page not found.');	
	}
}
