<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile', 'username'=>Yii::app()->user->name),
	UserModule::t("General"),
);

?>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>true, // whether this is a stacked menu
    'htmlOptions'=>array('style'=>'width:20%; float:left; margin-right:20px'),
    'items'=>array(
        array('label'=>'General', 'url'=>'general', 'active'=>true),
        array('label'=>'Password', 'url'=>'password'),
        array('label'=>'Shit', 'url'=>'#'),
    ),
)); ?>

<div class="span6">
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
        <?php echo CHtml::submitButton(UserModule::t("Save")); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
 

