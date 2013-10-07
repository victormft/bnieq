<?php $this->pageTitle=Yii::app()->name . ' - '.MessageModule::t("Compose Message"); ?>
<?php
	$this->breadcrumbs=array(
		MessageModule::t("Messages"),
		MessageModule::t("Compose"),
	);
?>

<div class="row">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
        'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>true, // whether this is a stacked menu
        'htmlOptions'=>array('style'=>'width:20%; float:left; margin-right:20px'),
        'items'=>array(
            array('label'=>'Inbox', 'url'=>'inbox'),
            array('label'=>'Sent', 'url'=>'sent'),
            array('label'=>'Compose', 'url'=>'compose', 'active'=>true),
        ),
    )); ?>
    
    <?php $this->renderPartial('_navigation'); ?>
    
	<div class="span8">
		<h2><?php echo MessageModule::t('Compose New Message'); ?></h2>

        <div class="form">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id'=>'message-form',
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note"><?php echo MessageModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

            <?php echo $form->errorSummary($model, null, null, array('class' => 'alert-message block-message error')); ?>


            <div class="input">
                <?php echo $form->labelEx($model,'receiver_id'); ?>
                <?php 
                //can message only when following
                if(Yii::app()->getModule('user')->isAdmin())
                {
                    $users=User::model()->findAll();
                    $list = CHtml::listData($users, 'id', function($user){return $user->getFullName();});
                }
                else {
                    if(User::model()->findbyPk(Yii::app()->user->id)->following)
                    {
                        $followings=User::model()->findbyPk(Yii::app()->user->id)->following;
                        $list = CHtml::listData($followings, 'followed_id', function($following){return $following->getNameOfFollowed();});
                    }
                }
                
                $this->widget('bootstrap.widgets.TbSelect2', array(                    
                    'name' => 'receiver',
                    'id' => 'receiver',
                    'value'=>$model->receiver_id,
                    'data' => $list,
                    'options' => array(
                        'width' => '220px',
                    )
                )); ?>

                <?php //echo CHtml::textField('receiver', $receiverName) ?>
                <?php //echo $form->hiddenField($model,'receiver_id'); ?>
                <?php echo $form->error($model,'receiver_id'); ?>
            </div>

            <?php echo $form->labelEx($model,'subject'); ?>
            <div class="input">
                <?php echo $form->textField($model,'subject'); ?>
                <?php echo $form->error($model,'subject'); ?>
            </div>

            <?php echo $form->labelEx($model,'body'); ?>
            <div class="input">
                <?php echo $form->textArea($model,'body'); ?>
                <?php echo $form->error($model,'body'); ?>
            </div>

            <div class="buttons">
                <button class="btn primary"><?php echo MessageModule::t("Send") ?></button>
            </div>

            <?php $this->endWidget(); ?>

        </div>
	</div>
</div>

