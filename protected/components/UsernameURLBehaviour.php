<?php

class UsernameURLBehaviour extends CBehavior {

    public function attach($owner) {
        // set the event callback
        $owner->attachEventHandler('onBeginRequest', array($this, 'beginRequest'));
    }

    /**
     * This method is attached to the 'onBeginRequest' event above.
     * */
    public function beginRequest(CEvent $event) {
        $route = Yii::app()->getUrlManager()->parseUrl(Yii::app()->getRequest());
        $exists = User::model()->exists('username = :username', array(':username' => $route));
        if ($exists && !is_array($event->sender->catchAllRequest)) {//if the route exists in username
            //catch all request to profile/view
            $event->sender->catchAllRequest = array(
                'user/profile',
                'username' => $route,
            );
        }
    }

}