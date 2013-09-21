<?php
/* @var $this PitchController */
/* @var $data Pitch */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startup_id')); ?>:</b>
	<?php echo CHtml::encode($data->startup_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('investment_required')); ?>:</b>
	<?php echo CHtml::encode($data->investment_required); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equity')); ?>:</b>
	<?php echo CHtml::encode($data->equity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('video')); ?>:</b>
	<?php echo CHtml::encode($data->video); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pitch_text')); ?>:</b>
	<?php echo CHtml::encode($data->pitch_text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exit_strategy')); ?>:</b>
	<?php echo CHtml::encode($data->exit_strategy); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	*/ ?>

</div>