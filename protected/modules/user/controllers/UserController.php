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
				'actions'=>array('followpop', 'founderpop'),
				'users'=>array('*'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view', 'follow', 'unfollow'),
				'users'=>array('@'),
			),
            array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('deleterelation'),
                'verbs'=>array('POST'),
				'users'=>array('@'),
			),
            array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
                
                $note = new Notification;
                $note->user_id = $model->id;
                $note->notification_type = Notification::FOLLOW_USER;
                $note->source_id = Yii::app()->user->id;
                $note->saveFollow(); 
                
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
                
                $note = new Notification;
                $note->user_id = $model->id;
                $note->notification_type = Notification::FOLLOW_USER;
                $note->source_id = Yii::app()->user->id;
                $note->save(); 
                
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
    
    public function actionFollowPop($id, $follow, $attr=NULL)
    {
        $model = $this->loadUser($id);
        
        switch ($follow){
            case 'ers':
                $provider = $model->followers;
                break;
            case 'ing':
                $provider = $model->following;
                break;
            case 'stup':
                $provider = $model->startupFollows;
                EQuickDlgs::render('_sfollowpop',array('provider'=>$provider));
                break;
        }
        EQuickDlgs::render('_followpop',array('provider'=>$provider, 'attr'=>$attr));
    }
    
    public function actionFounderPop($id)
    {
        $model = $this->loadUser($id);
        
        $provider = $model->getStartupsByRole("Founder");
        
        EQuickDlgs::render('_founderpop',array('provider'=>$provider));
    }
    
    /*
     * Delete the relation of a user and a startup
     */
    public function actionDeleteRelation($uid, $sid)
    {
        $startup = Startup::model()->findByPk($sid);
        if(!$startup->hasUserRelation())
            throw new CHttpException(403,'Você não pode fazer isso.');
        
        $user_startup=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$uid, ':s_id'=>$sid));
		$user_startup->delete();
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
