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
		$exists_s = Startup::model()->exists('startupname = :startupname', array(':startupname' => $route));
		
		$new_route_arr=explode('/', $route);
		$new_route=end($new_route_arr);
		$exists_es = Startup::model()->exists('startupname = :startupname', array(':startupname' => $new_route));
		
        if ($exists && !is_array($event->sender->catchAllRequest)) {//if the route exists in username
            //catch all request to profile/view
            $event->sender->catchAllRequest = array(
                'user/profile',
                'username' => $route,
            );
        }
		else if ($exists_s && !is_array($event->sender->catchAllRequest)) {//if the route exists in startupname
            //catch all request to startup/view
            $event->sender->catchAllRequest = array(
                'startup/view',
                'name' => $route,
            );
			
        }
		
		else if ($new_route_arr[0]=="edit" && $exists_es && !is_array($event->sender->catchAllRequest)) {//if the route exists in startupname
            //catch all request to startup/edit
            $event->sender->catchAllRequest = array(
                'startup/edit',
                'name' => $new_route,
            );
			
        }

    }

}