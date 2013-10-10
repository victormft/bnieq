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
	'inlineErrors'=>false,
)); ?>


<!--
<p class="help-block">Fields with <span class="required">*</span> are required.</p>
-->

<?php //echo $form->errorSummary($model); ?>

<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">
	<div class="warn" style="float:right; width:270px; border: 1px solid #ddd; background:#f4f4f4; border-radius:3px; padding:20px 15px 20px 5px; position:relative; color:#646464"><i class="icon-warning-sign" style="font-size:23px; color:#f28d0b; position:absolute; top:50%; margin-top:-8px;"></i><div style="margin-left:35px;">Máximo de 50 caracteres. Evite caracteres como & ' ".</div></div>
	<div style="float:left;">
	<?php echo $form->textFieldRow($model,'name',array('labelOptions' => array('label' => 'Nome da Startup', 'class'=>'custom-label'), 'class'=>'span3','maxlength'=>30)); ?>
	<?php echo $form->error($model,'name', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	<div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
	Nome que aparecerá no perfil público da Startup. Quanto mais direto e objetivo melhor.
	</div>
	</div>
</div>
<!--	
	<script type='text/javascript'>
	
		  $(function() {
			$('#Startup_name').tooltip({trigger: 'focus', placement: 'right', title: 'Nome que aparecerá no perfil público da Startup.'});
		  });
	
		  $(function() {
			$('#Startup_pic').tooltip({trigger: 'focus', placement: 'right', title: 'Entre com a imagem que representa o logotipo da Startup.'});
		  });
		  
		  $(function() {
			$('#Startup_one_line_pitch').tooltip({trigger: 'focus', placement: 'right', title: 'Descreva o que sua startup faz em apenas uma frase. Exemplo(NextBlue): A primeira rede social de investidores do Brasil.  '});
		  });
		  
		  $(function() {
			$('#Startup_product_description').tooltip({trigger: 'focus', placement: 'right', title: 'Descreva com mais detalhes o que é e qual a finalidade do produto da sua Startup. Exemplo(NextBlue): Uma plataforma que une investidores e empreendedores em uma rede social de investimento, permitindo que startups possam captar investimentos em troca de um percentual da empresa.'});
		  });
	
	
	</script>
-->	
<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">
	<div class="warn" style="float:right; width:270px; border: 1px solid #ddd; background:#f4f4f4; border-radius:3px; padding:20px 15px 20px 5px; position:relative; color:#646464"><i class="icon-warning-sign" style="font-size:23px; color:#f28d0b; position:absolute; top:50%; margin-top:-8px;"></i><div style="margin-left:35px;">Serão aceitos somente arquivos do tipo jpg, jpeg ou png.</div></div>
	<div style="float:left;">
	<?php echo $form->fileFieldRow($model,'pic',array('labelOptions' => array('label' => 'Logotipo', 'class'=>'custom-label'), 'class'=>'span4')); ?>
	<?php echo $form->error($model,'pic', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	<div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
	O Logo da sua Startup. A imagem será redimencionada para o tamanho 80x80px.
	</div>
	</div>
</div>
	

<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">
	<div class="warn" style="float:right; width:270px; border: 1px solid #ddd; background:#f4f4f4; border-radius:3px; padding:20px 15px 20px 5px; position:relative; color:#646464"><i class="icon-warning-sign" style="font-size:23px; color:#f28d0b; position:absolute; top:50%; margin-top:-8px;"></i><div style="margin-left:35px;">Máximo de 150 caracteres. A ideia é ser bem sucinto!!</div></div>
	<div style="float:left;">
	<?php echo $form->textFieldRow($model,'one_line_pitch',array('labelOptions' => array('label' => 'Pitch de uma Linha', 'class'=>'custom-label'), 'class'=>'span3','maxlength'=>30)); ?>
	<?php echo $form->error($model,'one_line_pitch', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	<div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
	Uma frase breve que descreva sua Startup. Na página de edição será possível descrever com mais detalhes.
	</div>
	</div>
</div>	
	<!--
	<?php echo $form->fileFieldRow($model, 'pic', array('labelOptions' => array('label' => 'Logo'), 'class'=>'span4')); ?>
	<?php echo $form->error($model,'pic', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	
	<?php echo $form->textFieldRow($model,'one_line_pitch', array('labelOptions' => array('label' => 'Pitch de Uma Linha'), 'class'=>'span4','maxlength'=>30)); ?>
	<?php echo $form->error($model,'one_line_pitch', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>

	<?php echo $form->textAreaRow($model,'product_description', array('labelOptions' => array('label' => 'O Produto'), 'rows'=>8, 'cols'=>50, 'class'=>'span4', 'maxlength'=>100)); ?>
	<?php echo $form->error($model,'product_description', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
-->
	
	<script>
		$("#Startup_product_description").charCount({
			allowed: 100,
			warning: 90
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
