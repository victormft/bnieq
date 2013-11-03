<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("General");

?>

<?php $this->renderPartial('_navigation', array('active'=>'general')); ?>

<div class="settings-wrap">
    <div class="span8">
        <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="successMessage">
        <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
        <?php endif; ?>

        <h1><?php echo UserModule::t("General"); ?></h1>

        <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'general-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>

            <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
            <?php echo $form->errorSummary($model); ?>

            <div class="row">
            <?php echo $form->labelEx($model,'username'); ?>
            <?php echo $form->textField($model,'username'); ?>
            <?php echo $form->error($model,'username'); ?>
            </div>

            <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email'); ?>
            <?php echo $form->error($model,'email'); ?>
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
 

