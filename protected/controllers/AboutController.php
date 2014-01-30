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
				'actions'=>array('como_funciona, quem_somos, ajuda, termos'),
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


	
	
}
