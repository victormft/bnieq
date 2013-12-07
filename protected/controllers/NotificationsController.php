<?php

class NotificationsController extends Controller
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
            $this->redirect(Yii::app()->controller->module->loginUrl);
        }
                
		$this->render('index',array(
            'model'=>User::model()->findbypk(Yii::app()->user->id),
        ));
                 
	}

}