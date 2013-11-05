<div class="settings-wrap">
    <div class="span3">
        
        <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'changepasswordnull-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>

            <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
            <?php echo $form->errorSummary($model); ?>


            <div class="row">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?>
            <p class="hint" style="margin-top: -8px">
            <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
            </p>
            </div>

            <div class="row">
            <?php echo $form->labelEx($model,'verifyPassword'); ?>
            <?php echo $form->passwordField($model,'verifyPassword'); ?>
            <?php echo $form->error($model,'verifyPassword'); ?>
            </div>


            <div class="row submit">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>'Salvar',
            )); ?>
            </div>

        <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div> 

