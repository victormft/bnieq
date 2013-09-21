<?php
/* @var $this PitchController */
/* @var $model Pitch */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pitch-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'startup_id'); ?>
		<?php echo $form->dropDownList($model,'startup_id', $model->getStartupOptions());?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'investment_required'); ?>
		<?php echo $form->textField($model,'investment_required',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'investment_required'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'equity'); ?>
		<?php echo $form->textField($model,'equity'); ?>
		<?php echo $form->error($model,'equity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'video'); ?>
		<?php echo $form->textField($model,'video',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'video'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pitch_text'); ?>
		<?php echo $form->textArea($model,'pitch_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'pitch_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'exit_strategy'); ?>
		<?php echo $form->textArea($model,'exit_strategy',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'exit_strategy'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
