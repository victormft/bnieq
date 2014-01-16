<?php

class DefaultController extends Controller
{
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        if(Yii::app()->user->isGuest){
            $user = Yii::app()->getComponent('user');
            $user->setFlash(
                'error',
                '<strong>Ops!</strong> Você precisa estar conectado para acessar essa área.'
            );
			$user->loginRequired();
        }
		$model=new Profile('search');
		$model->unsetAttributes();  // clear any default values
                
		if(isset($_GET['n'])) {
            $model->fullname=$_GET['n'];
			$model->resume=$_GET['n'];
		}
		
		if(isset($_GET['rol']))
			$model->roles=$_GET['rol'];	
        
        
        if(isset($_GET['ski']))
			$model->skills=$_GET['ski'];
        
        if(isset($_GET['sec']))
			$model->sectors=$_GET['sec'];
				
        if(isset($_GET['g']))
		{   
            $model->default_sort=false;
            $model->group=$_GET['g'];
		}
        
        if(isset($_GET['c']))
		{
			$model->location=$_GET['c'];
		}
		
		if(isset($_GET['Profile_sort']))
		{
			$model->default_sort=false;
		}
        
		$this->render('/user/index',array(
            'dataProvider'=>$model,
        ));
        
        /*
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
		        'condition'=>'status>'.User::STATUS_BANNED,
		    ),
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('/user/index',array(
			'dataProvider'=>$dataProvider,
		));
         */
         
	}

}