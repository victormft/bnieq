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
        
        
        if(isset($_GET['ski']))
			$model->skills=$_GET['ski'];
        
        if(isset($_GET['sec']))
			$model->sectors=$_GET['sec'];
		/*		
        if(isset($_GET['g']))
		{   
            $model->group=$_GET['g'];
			if($_GET['g']=='Empreendedores')
                $model->roles = isset($model->roles) ? array_merge($model->roles, array(5)) : array(5);
		}	
         * 
         */
        
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