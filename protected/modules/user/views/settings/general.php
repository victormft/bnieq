<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("General"); ?>

<?php $this->renderPartial('_navigation', array('active'=>'general')); ?>

<div class="settings-wrap">
    <div class="span3" style="margin-left: 0; float: left; border-right: 2px dotted #d4d4d4;">
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
    
    <div class="span3" style="float: left;">
        <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="successMessage">
        <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
        <?php endif; ?>

        <h1><?php echo UserModule::t("Keep me updated"); ?></h1>

        <div class="form">
        <?php $form=$this->beginWidget('TbActiveForm', array(
            'id'=>'newsletter-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>

            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->toggleButtonRow($model, 'newsletter', array('checked'=>$model->newsletter)); ?>
            
            <div class="spacing-5"></div>
            <div class="spacing-5"></div>
            
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
 

