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
	'enableClientValidation'=>true,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>


<!--
<p class="help-block">Fields with <span class="required">*</span> are required.</p>
-->

<?php //echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('labelOptions' => array('label' => 'Nome'), 'class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->error($model,'name', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	
	<script type='text/javascript'>
	
		  $(function() {
			$('#Startup_name').tooltip({trigger: 'hover', placement: 'right', title: 'Entre com o nome que aparecerá no perfil público da Startup.'});
		  });
	
		  $(function() {
			$('#Startup_pic').tooltip({trigger: 'hover', placement: 'right', title: 'Entre com a imagem que representa o logotipo da Startup.'});
		  });
		  
		  $(function() {
			$('#Startup_one_line_pitch').tooltip({trigger: 'hover', placement: 'right', title: 'Descreva o que sua startup faz em apenas uma frase. Exemplo(NextBlue): A primeira rede social de investidores do Brasil.  '});
		  });
		  
		  $(function() {
			$('#Startup_product_description').tooltip({trigger: 'hover', placement: 'right', title: 'Descreva com mais detalhes o que é e qual a finalidade do produto da sua Startup. Exemplo(NextBlue): Uma plataforma que une investidores e empreendedores em uma rede social de investimento, permitindo que startups possam captar investimentos em troca de um percentual da empresa.'});
		  });
	
	
	</script>
	
	<?php echo $form->fileFieldRow($model, 'pic', array('labelOptions' => array('label' => 'Logo'), 'class'=>'span5')); ?>
	<?php echo $form->error($model,'pic', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	
	<?php echo $form->textFieldRow($model,'one_line_pitch', array('labelOptions' => array('label' => 'Pitch de Uma Linha'), 'class'=>'span5','maxlength'=>30)); ?>
	<?php echo $form->error($model,'one_line_pitch', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>

	<?php echo $form->textAreaRow($model,'product_description', array('labelOptions' => array('label' => 'O Produto'), 'rows'=>8, 'cols'=>50, 'class'=>'span5', 'maxlength'=>1000)); ?>
	<?php echo $form->error($model,'product_description', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>

	
	<script>
		$("#Startup_product_description").charCount({
			allowed: 1000	
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
