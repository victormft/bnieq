<?php
/* @var $this PitchController */
/* @var $model Pitch */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pitch-form',
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'enableClientValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
	'inlineErrors'=>false,
)); ?>
	
	
	
	
		
		<h3 class="create-title">Pitch</h3> 
		<div class="create-sub-title" style="font-style:italic;">Preencha os dados do pitch:</div>
	
		<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
			<div style="float:left;">
			<?php echo $form->textFieldRow($model,'investment_required',array('labelOptions' => array('label' => 'Meta de Investimento', 'class'=>'custom-label'), 'class'=>'span2','maxlength'=>20)); ?>
			<?php echo $form->error($model,'investment_required');?>
			</div> 
		</div>
		
		<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
			<div style="float:left;">
			<?php echo $form->textFieldRow($model,'equity',array('labelOptions' => array('label' => 'Equity', 'class'=>'custom-label'), 'class'=>'span2','maxlength'=>20)); ?>
			<?php echo $form->error($model,'equity');?>
			</div> 
		</div>
		
	
	<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Salvar' : 'Salvar',
		)); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->