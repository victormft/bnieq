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
	
		<?php /*<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
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
		</div> */?>
		
		<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px; margin-top:20px;">
	<div class="warn" style="float:right; width:270px; border: 1px solid #ddd; background:#f4f4f4; border-radius:3px; padding:20px 15px 20px 5px; position:relative; color:#646464; box-shadow: -4px 4px 5px 0px #eaeaea;"><i class="icon-warning-sign" style="font-size:23px; color:#f28d0b; position:absolute; top:50%; margin-top:-8px;"></i><div style="margin-left:35px;">Caracteres numéricos</div></div>
	<div style="float:left;">
	<?php echo $form->textFieldRow($model,'investment_required',array('labelOptions' => array('label' => 'Meta de investimento', 'class'=>'custom-label'), 'class'=>'span3','maxlength'=>12)); ?>
	<?php echo $form->error($model,'investment_required', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	<div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
	Informe a meta de investimento da startup.
	</div>
	</div>
	</div>
	
	<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px; margin-top:20px;">
	<div class="warn" style="float:right; width:270px; border: 1px solid #ddd; background:#f4f4f4; border-radius:3px; padding:20px 15px 20px 5px; position:relative; color:#646464; box-shadow: -4px 4px 5px 0px #eaeaea;"><i class="icon-warning-sign" style="font-size:23px; color:#f28d0b; position:absolute; top:50%; margin-top:-8px;"></i><div style="margin-left:35px;">Caracteres numéricos</div></div>
	<div style="float:left;">
	<?php echo $form->textFieldRow($model,'equity',array('labelOptions' => array('label' => 'Equity', 'class'=>'custom-label'), 'class'=>'span3','maxlength'=>5)); ?>
	<?php echo $form->error($model,'equity', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	<div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
	Informe o equity.
	</div>
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