<?php
$this->layout='column1';
?>


<?php 

//Yii::app()->clientScript->registerCoreScript('jquery'); 
//Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/charCount.js');

/*Yii::app()->clientScript->registerScript('create-script',
"

	
	//$('.select2-input').focus(function(event){
	//	alert('ha');
	//	$('.select2-drop').css({'display':'none'});
	//});

");
*/
?>

<div class="sub-header-bg" style="margin-top:-20px;"></div>
<h1 class="create-title">Criar Startup</h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:60px;">Forneça os dados necessários para criar o perfil da Startup!</div>

<div class="create-wrap">

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

<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px; margin-top:20px;">
	<div class="warn" style="float:right; width:270px; border: 1px solid #ddd; background:#f4f4f4; border-radius:3px; padding:20px 15px 20px 5px; position:relative; color:#646464; box-shadow: -4px 4px 5px 0px #eaeaea;"><i class="icon-warning-sign" style="font-size:23px; color:#f28d0b; position:absolute; top:50%; margin-top:-8px;"></i><div style="margin-left:35px;">Máximo de 40 caracteres. Evite caracteres especiais , como &.</div></div>
	<div style="float:left;">
	<?php echo $form->textFieldRow($model,'name',array('labelOptions' => array('label' => 'Nome da Startup', 'class'=>'custom-label'), 'class'=>'span3','maxlength'=>40)); ?>
	<?php echo $form->error($model,'name', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	<div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
	Nome que aparecerá no perfil público da Startup. Quanto mais direto e objetivo melhor.
	</div>
	</div>
</div>


<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">
	<div class="warn" style="float:right; width:270px; border: 1px solid #ddd; background:#f4f4f4; border-radius:3px; padding:20px 15px 20px 5px; position:relative; color:#646464; box-shadow: -4px 4px 5px 0px #eaeaea;"><i class="icon-warning-sign" style="font-size:23px; color:#f28d0b; position:absolute; top:50%; margin-top:-8px;"></i><div style="margin-left:35px;">Imagens do tipo jpg, jpeg ou png. Procure usar imagens quadradas!! (Exemplo: 200x200px). </div></div>
	<div style="float:left;">
	<?php echo $form->fileFieldRow($model,'pic',array('labelOptions' => array('label' => 'Logotipo', 'class'=>'custom-label'), 'class'=>'span4')); ?>
	<!-- necessário isso aqui, por causa da classe de errorcss<?php echo $form->error($model,'pic', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>-->
	<div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
	O Logo da sua Startup. A imagem será redimensionada para o tamanho 120x120px.
	</div>
	</div>
</div>
	

<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">
	<div class="warn" style="float:right; width:270px; border: 1px solid #ddd; background:#f4f4f4; border-radius:3px; padding:20px 15px 20px 5px; position:relative; color:#646464; box-shadow: -4px 4px 5px 0px #eaeaea;"><i class="icon-warning-sign" style="font-size:23px; color:#f28d0b; position:absolute; top:50%; margin-top:-8px;"></i><div style="margin-left:35px;">Máximo de 80 caracteres. A ideia é ser bem sucinto!!</div></div>
	<div style="float:left;">
	<?php echo $form->textFieldRow($model,'one_line_pitch',array('labelOptions' => array('label' => 'Pitch de uma Linha', 'class'=>'custom-label'), 'class'=>'span3','maxlength'=>80)); ?>
	<?php echo $form->error($model,'one_line_pitch', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	<div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
	Uma frase breve que descreva sua Startup. Na página de edição será possível descrever com mais detalhes.
	</div>
	</div>
</div>	

<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">
	<div class="warn" style="float:right; width:270px; border: 1px solid #ddd; background:#f4f4f4; border-radius:3px; padding:20px 15px 20px 5px; position:relative; color:#646464; box-shadow: -4px 4px 5px 0px #eaeaea;"><i class="icon-warning-sign" style="font-size:23px; color:#f28d0b; position:absolute; top:50%; margin-top:-8px;"></i><div style="margin-left:35px;">Digite no mínimo 3 caracteres para selecionar a cidade.</div></div>
	<div style="float:left;">
	<?php echo $form->select2Row($model,'location',
			array(		
				'labelOptions' => array('label' => 'Cidade', 'class'=>'custom-label'),
				'data'=>array_merge(array('0'=>'Digite o nome da cidade...'),Cidade::model()->getCities()),
				'options'=>array(
					'allowClear'=> true,   
					'dropdownAutoWidth'=> true,
					'minimumInputLength'=> 3,
					'width'=>'270px',
				),
				
			)
	); ?>
	<?php echo $form->error($model,'location', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	<div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
	A cidade onde a Startup está sediada no momento.
	</div>
	</div>
</div>




	<!--
	<?php //echo $form->fileFieldRow($model, 'pic', array('labelOptions' => array('label' => 'Logo'), 'class'=>'span4')); ?>
	<?php //echo $form->error($model,'pic', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
	
	<?php //echo $form->textFieldRow($model,'one_line_pitch', array('labelOptions' => array('label' => 'Pitch de Uma Linha'), 'class'=>'span4','maxlength'=>30)); ?>
	<?php //echo $form->error($model,'one_line_pitch', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>

	<?php //echo $form->textAreaRow($model,'product_description', array('labelOptions' => array('label' => 'O Produto'), 'rows'=>8, 'cols'=>50, 'class'=>'span4', 'maxlength'=>100)); ?>
	<?php //echo $form->error($model,'product_description', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
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
			'label'=>$model->isNewRecord ? 'Salvar' : 'Salvar',
		)); ?>
</div>

<?php $this->endWidget(); ?>

</div>