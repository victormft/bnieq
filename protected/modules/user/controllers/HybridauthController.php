<?php
class HybridauthController extends Controller{
 
    public $defaultAction='authenticate';
    public $debugMode=true;
 
    // important! all providers will access this action, is the route of 'base_url' in config
    public function actionEndpoint(){
        Yii::app()->hybridAuth->endPoint();
    }
 
    public function actionAuthenticate($provider='Facebook'){
        if(!Yii::app()->user->isGuest || !Yii::app()->hybridAuth->isAllowedProvider($provider))
            $this->redirect(Yii::app()->homeUrl);
 
        if($this->debugMode)
            Yii::app()->hybridAuth->showError=true;
 
        if(Yii::app()->hybridAuth->isAdapterUserConnected($provider)){
            $socialUser = Yii::app()->hybridAuth->getAdapterUserProfile($provider);
            if(isset($socialUser)){
                // find user from db model with social user info
                $user = User::model()->findBySocial($provider, $socialUser->identifier);
                if(empty($user)){ 
                    // if not exist register new user with social user info.
                    $model = new User('register');
                    $model->social_provider = $provider;
                    $model->social_identifier = $socialUser->identifier;
                    $model->social_avatar = $socialUser->photoURL;
                    $model->email = $socialUser->email;
                    if($model->save()){
                       $user=$model; 
                    }else{
                       $user=false;
                    }
                }
 
                if($user){
                    $identity = new UserIdentity($user->social_info1, $user->social_info2);
                    $identity->authenticate('social');
                    switch ($identity->errorCode) {
                      case UserIdentity::ERROR_NONE:
                           Yii::app()->user->login($identity);
                           $this->redirect(Yii::app()->request->urlReferer);
                           break;
                    }
                }
            }
        }
        $this->redirect(Yii::app()->homeUrl);
    }
 
    public function actionLogout(){
 
        if(Yii::app()->hybridAuth->getConnectedProviders()){
            Yii::app()->hybridAuth->logoutAllProviders();
        }
 
        Yii::app()->user->logout();    
    }
 
}