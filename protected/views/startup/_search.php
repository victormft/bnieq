<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>99)); ?>

		<?php echo $form->textFieldRow($model,'logo',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textAreaRow($model,'one_line_pitch',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'product_description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'company_size',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'company_stage',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'foundation',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>99)); ?>

		<?php echo $form->textFieldRow($model,'telephone',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'skype',array('class'=>'span5','maxlength'=>99)); ?>

		<?php echo $form->textFieldRow($model,'company_number',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'facebook',array('class'=>'span5','maxlength'=>150)); ?>

		<?php echo $form->textFieldRow($model,'twitter',array('class'=>'span5','maxlength'=>150)); ?>

		<?php echo $form->textFieldRow($model,'blog',array('class'=>'span5','maxlength'=>150)); ?>

		<?php echo $form->textFieldRow($model,'address',array('class'=>'span5','maxlength'=>20)); ?>

		<?php echo $form->textAreaRow($model,'client_segment',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'value_proposition',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'market_size',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'sales_marketing',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'revenue_generation',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'competitors',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textAreaRow($model,'competitive_advantage',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

		<?php echo $form->textFieldRow($model,'video',array('class'=>'span5','maxlength'=>150)); ?>

		<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
