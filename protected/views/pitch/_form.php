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
	
	<?php 
	///Maybe this will be moved to another section but I will leave here for a while until I find a better way to struct it.
		if($profile->firstname == NULL || $profile->lastname==NULL || $profile->birthday == NULL)
			echo '<h3>Profile</h3>';
		if($profile->firstname == NULL) {
			echo '<div class="row">';
			echo $form->labelEx($profile, 'firstname');
			echo $form->textField($profile,'firstname',array('size'=>20,'maxlength'=>50));
			echo $form->error($profile,'firstname');
			echo '</div>';
		}
		if($profile->lastname == NULL) {
			echo '<div class="row">';
			echo $form->labelEx($profile, 'lastname');
			echo $form->textField($profile,'lastname',array('size'=>20,'maxlength'=>50));
			echo $form->error($profile,'lastname');
			echo '</div>';
		}
		if($profile->birthday == NULL) {
			echo '<div class="row">';
			echo $form->labelEx($profile, 'birthday');
			echo $form->textField($profile,'birthday',array('size'=>10,'maxlength'=>10));
			echo $form->error($profile,'birthday');
			echo '</div>';
		}
		if($profile->gender == NULL) {
			echo '<div class="row">';
			echo $form->labelEx($profile, 'gender');
			echo $form->dropDownList($profile,'gender', $profile->getGenderOptions());
			echo '</div>';
		}
		
		if($profile->telephone == NULL) {
			echo '<div class="row">';
			echo $form->labelEx($profile, 'telephone');
			echo $form->textField($profile,'telephone',array('size'=>15,'maxlength'=>15));
			echo $form->error($profile,'telephone');
			echo '</div>';
		}
	
	?>
	
	<?php
	if($startup->company_number == NULL || $startup->location==NULL)
			echo '<h3>Company</h3>';
	if($startup->company_number == NULL) {
			echo '<div class="row">';
			echo $form->labelEx($startup, 'company_number');
			echo $form->textField($startup,'company_number',array('size'=>50,'maxlength'=>50));
			echo $form->error($startup,'company_number');
			echo '</div>';
		}
	
	if($startup->location == NULL) {
			echo '<div class="row">';
			echo $form->labelEx($startup, 'location');
			echo $form->textField($startup,'location',array('size'=>50,'maxlength'=>50));
			echo $form->error($startup,'location');
			echo '</div>';
		}
			
	?>
	<h3>Pitch</h3>

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
