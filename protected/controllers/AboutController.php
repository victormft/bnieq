<?php

class AboutController extends Controller
{
	
	
	/**
	* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	* using two-column layout. See 'protected/views/layouts/column2.php'.
	*/
	public $layout='//layouts/column1';


	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('como_funciona, quem_somos, ajuda, termos, contato, addMessage'),
				'users'=>array('*'),
			),
		);
	}

	public function missingAction($action)
    {
        $action=str_replace('-','_',$action);
        $action='action'.ucfirst(strtolower($action));
        if(method_exists($this,$action))
            $this->$action();
        else
            $this->actionIndex();
    }
	
	public function actionComo_Funciona()
	{
		$this->render('como_funciona',array(
                
            ));
	}
	
	public function actionQuem_Somos()
	{
		$this->render('quem_somos',array(
                
            ));
	}
	
	public function actionAjuda()
	{
		$this->render('ajuda',array(
                
            ));
	}
	
	public function actionTermos()
	{
		$this->render('termos',array(
                
            ));
	}
	
	public function actionContato()
	{
		if(Yii::app()->user->isGuest)
		{
			$app=Yii::app();
			$app->user->setReturnUrl($app->request->getUrl());
		}
		
		$this->render('contato',array(
                
            ));
	}
	
	public function actionAddContact()
	{
		if(Yii::app()->user->isGuest)
		{
			throw new CHttpException(403,'Ação inválida!');
		}
		
		
		$contact = new Contact;
		
		$contact->user_id = Yii::app()->user->id;
		$contact->type = 1;
		$contact->text = $_POST['text'];   
		
		if(empty($_POST['text']))
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>'Preencha o campo corretamente'
			));
			exit;
		}
		
		else
		{	
		
			$contact->save();
			
			echo CJSON::encode(array(
				'res'=>'ok',
				'msg'=>'Sucesso!'
			));
			exit;
		}
		
	}

	public function actionAddMessage()
	{
		if(Yii::app()->user->isGuest)
		{
			throw new CHttpException(403,'Ação inválida!');
		}
		
		
		$message = new Message;
		
		$message->sender_id = Yii::app()->user->id;
		$message->receiver_id  = 1; // message for the admin
		$message->subject = $_POST['subject'];   
		$message->body = $_POST['body'];
		
		if(empty($_POST['subject']) || empty($_POST['body']))
		{
			echo CJSON::encode(array(
				'res'=>'no',
				'msg'=>'Preencha os campos corretamente'
			));
			exit;
		}
		
		else
		{	
		
			$message->save();
			
			echo CJSON::encode(array(
				'res'=>'ok',
				'msg'=>'Sucesso!'
			));
			exit;
		}
		
	}

	
	
}
