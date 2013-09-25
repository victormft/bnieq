<h2><?php echo ($model->receiver_id)?'Message '.User::model()->findbyPk($model->receiver_id)->getFullName().'':MessageModule::t('Compose New Message'); ?></h2>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'message-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note"><?php echo MessageModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo $form->errorSummary($model, null, null, array('class' => 'alert-message block-message error')); ?>


    <div class="input" <?php echo ($model->receiver_id)?'style=display:none;':'' ?>>
        <?php echo $form->labelEx($model,'receiver_id'); ?>
        <?php 
        $users=User::model()->findAll();
        $this->widget('bootstrap.widgets.TbSelect2', array(                    
            'name' => 'receiver',
            'id' => 'receiver',
            'value'=>$model->receiver_id,
            'data' => CHtml::listData($users, 'id', function($user){return $user->getFullName();}),
            'options' => array(
                'width' => '40%',
            )
        )); ?>
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