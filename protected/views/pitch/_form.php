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
	
	
	<?php 
	///Maybe this will be moved to another section but I will leave here for a while until I find a better way to struct it.
		if($profile->firstname == NULL || $profile->lastname==NULL || $profile->birthday == NULL 
			|| $profile->telephone == NULL || $profile->gender == NULL)

			echo '<h3 class="create-title">Perfil</h3> 
			<div class="create-sub-title" style="font-style:italic;">Complete os seguintes dados do perfil antes de criar um pitch:</div>';
			
		if($profile->firstname == NULL) {
			echo '<div class="row">';
			echo $form->textFieldRow($profile,'firstname',array('labelOptions' => array('label' => 'Nome', 'class'=>'custom-label'), 'class'=>'span3','maxlength'=>30));
			echo $form->error($profile,'firstname', array('errorCssClass'=>'', 'successCssClass'=>'' ));
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
		
			echo '<div style="padding-bottom:15px;"></div>';
			echo '<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:15px;">';
			echo '<div style="float:left;">';
			//echo $form->textFieldRow($profile,'birthday',array('labelOptions' => array('label' => 'Data de nascimento', 'class'=>'custom-label'), 'class'=>'span2','maxlength'=>10, 'size'=>8) );
			//echo $form->error($profile,'birthday', array('errorCssClass'=>'', 'successCssClass'=>'' ));
			echo '<span class="custom-label"><span class="span2">Data de Nascimento</span></span>';
			$this->widget('editable.EditableField', array(
						'type'      => 'combodate',
                        'model'     => $profile,
                        'attribute' => 'birthday',
                        'mode'      => 'popup',
                        'placement' => 'left',
                        'format'      => 'YYYY-MM-DD', //format in which date is expected from model and submitted to server
                        'viewformat'  => 'DD/MM/YYYY', //format in which date is displayed
                        'template'    => 'D / MMM / YYYY',
                        'options'   => array(
                            'defaultValue'   => date('Y-m-d'),
                        )
                     ));
			echo $form->error($profile,'birthday', array('errorCssClass'=>'', 'successCssClass'=>'' ));

			echo '</div></div>';
		}
		if($profile->gender == NULL) {
			//echo '<div class="row">';
			echo '<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">';
			echo '<div style="float:left;">';
			echo $form->dropDownListRow($profile,'gender', $profile->getGenderOptions(), array('labelOptions' => array('label' => 'Sexo', 'class'=>'custom-label'), 'class'=>'span2',));
			echo '</div> </div>';
			
		}
		
		if($profile->telephone == NULL) {
			echo '<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">';
			echo '<div style="float:left;">';
			echo $form->textFieldRow($profile,'telephone',array('labelOptions' => array('label' => 'Número de telefone', 'class'=>'custom-label'), 'class'=>'span2','maxlength'=>10));
			echo $form->error($profile,'telephone', array('errorCssClass'=>'', 'successCssClass'=>'' ));
			echo '</div> </div>';
		}
		
		echo '<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">';
		echo '</div>';
	
	?>
	
	<?php
	if($startup->company_number == NULL || $startup->location==NULL)
			echo '<h3 class="create-title">Startup</h3>
			<div class="create-sub-title" style="font-style:italic;">Complete os seguintes dados da startup antes de criar um pitch:</div>';
			
	if($startup->company_number == NULL) {
			echo '<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">';
			echo '<div style="float:left;">';
			echo $form->textFieldRow($startup,'company_number',array('labelOptions' => array('label' => 'CNPJ', 'class'=>'custom-label'), 'class'=>'span2','maxlength'=>20));
			echo $form->error($startup,'company_number', array('errorCssClass'=>'', 'successCssClass'=>'' ));
			echo '</div></div>';
		}
	
	if($startup->location == NULL) {
			echo '<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">';
			echo '<div style="float:left;">';
			echo $form->select2Row($startup,'location',
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
	); 
			echo $form->error($startup,'location', array('errorCssClass'=>'', 'successCssClass'=>'' ));
			echo '</div> </div>';
		}
		
		//faltanto post code, business growth stage, sectors, business plan, financial forecast
		echo '<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">';
		echo '</div>';
			
	?>
	
		
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
		
		<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
			<div style="float:left;">
			<?php echo $form->textFieldRow($model,'video',array('labelOptions' => array('label' => 'Url do vídeo', 'class'=>'custom-label'), 'class'=>'span2','maxlength'=>20)); ?>
			<?php echo $form->error($model,'video'); ?>
			</div> 
		</div>
		
	<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
		<div style="float:left;">
		<?php echo $form->textAreaRow($model,'pitch_text',  array('rows'=>6, 'cols'=>30, 'labelOptions' => array('label' => 'Descrição', 'class'=>'custom-label'), 'class'=>'span7',)  ); ?>
		<?php echo $form->error($model,'pitch_text'); ?>
		</div>
	</div>

	<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
		<div style="float:left;">
		<?php echo $form->textAreaRow($model,'exit_strategy',  array('rows'=>6, 'cols'=>30, 'labelOptions' => array('label' => 'Estratégia', 'class'=>'custom-label'), 'class'=>'span7',)  ); ?>
		<?php echo $form->error($model,'exit_strategy'); ?>
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