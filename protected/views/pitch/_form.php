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
	
	
	<?php if($profile->firstname == NULL || $profile->lastname==NULL || $profile->birthday == NULL
			|| $profile->telephone == NULL || $profile->gender == NULL) : ?>

			<h3 class="create-title">Perfil</h3> 
			<div class="create-sub-title" style="font-style:italic;">Complete os seguintes dados do perfil antes de criar um pitch:</div>
			
		<?php if($profile->firstname == NULL): ?>
			<div class="row">
			<?php echo $form->textFieldRow($profile,'firstname',array('labelOptions' => array('label' => 'Nome', 'class'=>'custom-label'), 'class'=>'span3','maxlength'=>30));?>
			<?php echo $form->error($profile,'firstname', array('errorCssClass'=>'', 'successCssClass'=>'' ));?>
			</div>
			<?php endif; ?>
			
		<?php if($profile->lastname == NULL): ?>
			<div class="row">
			<?php echo $form->labelEx($profile, 'lastname'); ?>
			<?php echo $form->textField($profile,'lastname',array('size'=>20,'maxlength'=>50)); ?>
			<?php echo $form->error($profile,'lastname'); ?>
			</div>
		<?php endif; ?>
		
		<?php if($profile->birthday == NULL): ?>
		
			<div style="padding-bottom:15px;"></div>
			<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:15px;">
			<div style="float:left;">
			<span class="custom-label"><span class="span2">Data de Nascimento</span></span>
			<?php $this->widget('editable.EditableField', array(
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
			?>
			
			<?php echo $form->error($profile,'birthday', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>

			</div> </div>
			<?php endif; ?>
	
		<?php if($profile->gender == NULL): ?>
			<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
				<div style="float:left;">
				<?php echo $form->dropDownListRow($profile,'gender', $profile->getGenderOptions(), array('labelOptions' => array('label' => 'Sexo', 'class'=>'custom-label'), 'class'=>'span2',));?>
				</div> 
			</div>
		<?php endif; ?>
		
		
		<?php if($profile->telephone == NULL): ?> 
			<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
				<div style="float:left;">
				<?php echo $form->textFieldRow($profile,'telephone',array('labelOptions' => array('label' => 'Número de telefone', 'class'=>'custom-label'), 'class'=>'span2','maxlength'=>10));?>
				<?php echo $form->error($profile,'telephone', array('errorCssClass'=>'', 'successCssClass'=>'' ));?>
				</div> 
			</div>
		<?php endif; ?>
		
		<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">
		</div>
	
	<?php endif; ?>
	
	<?php if($startup->company_number == NULL || $startup->location==NULL) : ?>
			<h3 class="create-title">Startup</h3>
			<div class="create-sub-title" style="font-style:italic;">Complete os seguintes dados da startup antes de criar um pitch:</div>
			
	<?php if($startup->company_number == NULL): ?> 
			<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
				<div style="float:left;">
				<?php echo $form->textFieldRow($startup,'company_number',array('labelOptions' => array('label' => 'CNPJ', 'class'=>'custom-label'), 'class'=>'span2','maxlength'=>20));?>
				<?php echo $form->error($startup,'company_number', array('errorCssClass'=>'', 'successCssClass'=>'' ));?>
				</div>
			</div>
	<?php endif; ?>
	
	<?php if($startup->location == NULL) : ?>
			<div class="group-wrap" style="border-bottom:1px #aaa; padding-bottom:30px; overflow:auto; margin-bottom:20px;">
				<div style="float:left;">
				<?php echo $form->select2Row($startup,'location',
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
				<?php echo $form->error($startup,'location', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
				</div> 
			</div>
	<?php endif;?>
		
		<!--faltanto post code, business growth stage, sectors, business plan, financial forecast -->
		<div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">
		</div>
			
	<?php endif;?>
	
		
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