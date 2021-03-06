<?php

class MessagesController extends Controller
{
	public $defaultAction = 'inbox';

    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
		);
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
				'users'=>array('@'),
			),
            array('deny',  // allow all users to perform 'index' and 'view' actions
				'users'=>array('*'),
			),
		);
	}
    
	public function actionInbox() 
    {
        $model=new Message('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Message']))
            $model->attributes=$_GET['Message'];
        
		$this->render('inbox', array(
            'model' => $model,
		));
	}
    /*
    public function actionCompose() 
    {
		$message = new Message();        
		if (Yii::app()->request->getPost('Message')) {            
            $message->receiver_id = Yii::app()->request->getPost('receiver');
			$receiverName = User::model()->findByPk($message->receiver_id)->username;
		    $message->attributes = Yii::app()->request->getPost('Message');            
			$message->sender_id = Yii::app()->user->getId();
			if ($message->save()) {                
				Yii::app()->user->setFlash('messageModule', 'Message has been sent');
			    $this->redirect($this->createUrl('messages/inbox/'));
			} else if ($message->hasErrors('receiver_id')) {
				$message->receiver_id = null;
				$receiverName = '';
			}
		} 
		$this->render('compose', array('model' => $message, 'receiverName' => isset($receiverName) ? $receiverName : null));
	}
     * 
     */
    
    public function actionComposeWithId($id)
    {    
        $message = new Message();        
		if (Yii::app()->request->getPost('Message')) {
            if(!Yii::app()->getModule('user')->isAdmin())
                if($id == Yii::app()->user->getId() || !User::model()->findbyPk(Yii::app()->user->getId())->hasUserFollowed($id))
                {
                    Yii::app()->user->setFlash('error', 'You can only message who you follow.');
                    $this->redirect(Yii::app()->request->urlReferrer);
                }
            $message->receiver_id = $id;
			$receiverName = User::model()->findByPk($message->receiver_id)->username;
		    $message->attributes = Yii::app()->request->getPost('Message');            
			$message->sender_id = Yii::app()->user->getId();
			if ($message->save()) {                
				Yii::app()->user->setFlash('success', 'Message has been sent');
                $this->redirect(Yii::app()->request->urlReferrer);			
                
            } else {
				Yii::app()->user->setFlash('error', 'Message incomplete');
                $this->redirect(Yii::app()->request->urlReferrer);                
            }
		} else {
			if ($id) {
				$receiver = User::model()->findbyPk($id);
				if ($receiver) {
                    if($receiver->hasUserFollowing(Yii::app()->user->id)){
                        $receiverName = $receiver->getFullName();
                        $message->receiver_id = $receiver->id;

                        $this->renderPartial('_compose', array('model' => $message, 'receiverName' => isset($receiverName) ? $receiverName : null));                    
				
                    }
                    else{
                        echo "Você só pode envar mensagens para quem você segue.";
                    }
                }
			}
		}		
	}
    
    public function actionDelete($id = null) {
		if (!$id) {
			$messagesData = Yii::app()->request->getParam('Message');
			$counter = 0;
			if ($messagesData) {
				foreach ($messagesData as $messageData) {
					if (isset($messageData['selected'])) {
						$message = Message::model()->findByPk($messageData['id']);
						if ($message->deleteByUser(Yii::app()->user->getId())) {
							$counter++;
						}
					}
				}
			}
			if ($counter) {
//pau??
				Yii::app()->user->setFlash('messageModule', $counter. ' message'.($counter > 1 ? 's' : '').' has been deleted');
			}
			$this->redirect(Yii::app()->request->getUrlReferrer());
		} else {
			$message = Message::model()->findByPk($id);

			if (!$message) {
				throw new CHttpException(404,'Message not found');
			}

			$folder = $message->receiver_id == Yii::app()->user->getId() ? 'messages/inbox/' : 'messages/sent/';

			if ($message->deleteByUser(Yii::app()->user->getId())) {
				Yii::app()->user->setFlash('messageModule', 'Message has been deleted');
			}
			$this->redirect($this->createUrl($folder));
		}       
	}
    public function actionSent() {
        
        $model=new Message('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Message']))
            $model->attributes=$_GET['Message'];
        
		$this->render('sent', array(
            'model' => $model,
		));
	}
    
    public function actionView() {
		$messageId = (int)Yii::app()->request->getParam('message_id');
		$viewedMessage = Message::model()->findByPk($messageId);

		if (!$viewedMessage) {
			 throw new CHttpException(404, UserModule::t('Message not found'));
		}

		$userId = Yii::app()->user->getId();

		if ($viewedMessage->sender_id != $userId && $viewedMessage->receiver_id != $userId) {
		    throw new CHttpException(403, UserModule::t('You can not view this message'));
		}
		if (($viewedMessage->sender_id == $userId && $viewedMessage->deleted_by == Message::DELETED_BY_SENDER)
		    || $viewedMessage->receiver_id == $userId && $viewedMessage->deleted_by == Message::DELETED_BY_RECEIVER) {
		    throw new CHttpException(404, UserModule::t('Message not found'));
		}
		$message = new Message();

		$isIncomeMessage = $viewedMessage->receiver_id == $userId;
		if ($isIncomeMessage) {
		    $message->subject = preg_match('/^Re:/',$viewedMessage->subject) ? $viewedMessage->subject : 'Re: ' . $viewedMessage->subject;
			$message->receiver_id = $viewedMessage->sender_id;
		} else {
			$message->receiver_id = $viewedMessage->receiver_id;
		}

		if (Yii::app()->request->getPost('Message')) {
			$message->attributes = Yii::app()->request->getPost('Message');
			$message->sender_id = $userId;
			if ($message->save()) {
				Yii::app()->user->setFlash('success', UserModule::t('Message has been sent'));
			    if ($isIncomeMessage) {
					$this->redirect($this->createUrl('messages/inbox/'));
			    } else {
					$this->redirect($this->createUrl('messages/sent/'));
				}
			}
		}

		if ($isIncomeMessage) {
			$viewedMessage->markAsRead();
		}

        //EQuickDlgs::renderPartial('view',array('viewedMessage' => $viewedMessage, 'message' => $message));
        
		$this->render('view', array('viewedMessage' => $viewedMessage, 'message' => $message));
	}
}
