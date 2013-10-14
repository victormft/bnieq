<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model)); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>99)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'one_line_pitch'); ?>
		<?php echo $form->textField($model,'one_line_pitch',array('size'=>30,'maxlength'=>99)); ?>
		<?php echo $form->error($model,'one_line_pitch'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'selecionada'); ?>
		<?php echo $form->dropDownList($model,'selecionada',Startup::itemAlias('StartupSelecionada')); ?>
		<?php echo $form->error($model,'selecionada'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(UserModule::t('Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->