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


<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span4','maxlength'=>30)); ?>
	
	<?php echo $form->fileFieldRow($model, 'pic', array('labelOptions' => array('label' => 'Logo'))); ?>
	
	<?php echo $form->textFieldRow($model,'one_line_pitch',array('class'=>'span4','maxlength'=>30)); ?>

	<?php echo $form->textAreaRow($model,'product_description',array('rows'=>8, 'cols'=>50, 'class'=>'span4', 'maxlength'=>30)); ?>
	
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
