<?php 

Yii::app()->clientScript->registerCoreScript('jquery'); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/charCount.js');


?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'startup-form',
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data'),
)); ?>



<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<fieldset>
	<legend>Company</legend>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('maxlength'=>30)); ?>
	
	<?php echo $form->fileFieldRow($model, 'pic', array('labelOptions' => array('label' => 'Logo'))); ?>
	
	<?php echo $form->textFieldRow($model,'one_line_pitch',array('maxlength'=>30)); ?>
	
	<?php echo $form->dropDownListRow($model, 'company_size', array('Something ...', '1', '2', '3', '4', '5')); ?>
	
	<?php echo $form->dropDownListRow($model, 'company_stage', array('Something ...', '1', '2', '3', '4', '5')); ?>
	
	<?php echo $form->datepickerRow($model, 'foundation', array('append'=>'<i class="icon-calendar"></i>')); ?>
	
	<?php echo $form->textFieldRow($model, 'email', array('append'=>'@')); ?>
	
	<?php echo $form->textFieldRow($model,'telephone',array('maxlength'=>30)); ?>
	
	<?php echo $form->textFieldRow($model,'skype',array('maxlength'=>30)); ?>
	
	<?php echo $form->textFieldRow($model,'company_number',array('maxlength'=>30)); ?>

</fieldset>
	
	<?php /*


	<b><?php echo CHtml::encode($data->getAttributeLabel('facebook')); ?>:</b>
	<?php echo CHtml::encode($data->facebook); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('twitter')); ?>:</b>
	<?php echo CHtml::encode($data->twitter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blog')); ?>:</b>
	<?php echo CHtml::encode($data->blog); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_segment')); ?>:</b>
	<?php echo CHtml::encode($data->client_segment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value_proposition')); ?>:</b>
	<?php echo CHtml::encode($data->value_proposition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('market_size')); ?>:</b>
	<?php echo CHtml::encode($data->market_size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_marketing')); ?>:</b>
	<?php echo CHtml::encode($data->sales_marketing); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('revenue_generation')); ?>:</b>
	<?php echo CHtml::encode($data->revenue_generation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('competitors')); ?>:</b>
	<?php echo CHtml::encode($data->competitors); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('competitive_advantage')); ?>:</b>
	<?php echo CHtml::encode($data->competitive_advantage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('video')); ?>:</b>
	<?php echo CHtml::encode($data->video); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	*/ ?>
	
	
	
	<script>
		$("#Startup_product_description").charCount({
			allowed: 30,		
			warning: 20,
			counterText: 'Characters left: '	
		});
	</script>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
