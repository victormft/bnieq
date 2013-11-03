<h2><?php echo 'Message '.$receiverName ?></h2>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'message-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>

    <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo $form->errorSummary($model, null, null, array('class' => 'alert-message block-message error')); ?>

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
        <button class="btn primary"><?php echo UserModule::t("Send") ?></button>
    </div>

    <?php $this->endWidget(); ?>

</div>