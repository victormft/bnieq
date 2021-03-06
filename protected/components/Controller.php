<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    
    public function init()
    {
        parent::init();
        $app = Yii::app();
        if (isset($_POST['lang']))
        {
            $app->language = $_POST['lang'];
            $app->session['lang'] = $app->language;
        }
        else if (isset($app->session['lang']))
        {
            $app->language = $app->session['lang'];
        }
    }
    
    
    protected function beforeAction($action)
    {
        if(!Yii::app()->user->isGuest)
            if(Yii::app()->user->status==-1)
            {                
                Yii::app()->user->logout();
                $this->redirect(Yii::app()->homeUrl . '/user/login');
            }
                
        /*
        $_uri = false;
        if (Yii::app()->urlManager->showScriptName == false){
            if (strpos(Yii::app()->request->requestUri, '/index.php') !== false){
                $_uri = str_replace("/index.php", "", Yii::app()->request->requestUri);
            }
            if (Yii::app()->controller->action->id == 'index'){
                if (!$_uri) {
                    if (strpos(Yii::app()->request->requestUri, "/index") !== false){
                        $_uri = str_replace("/index", "", Yii::app()->request->requestUri);
                    }
                } else {
                    if (strpos($_uri, "/index") !== false){
                        $_uri = str_replace("/index", "", $_uri);
                    }
                }
            }
        }

        if ($_uri !== false){
            $this->redirect($_uri);
        }
         * * */
         
        return parent::beforeAction($action);
         
         
    }
}