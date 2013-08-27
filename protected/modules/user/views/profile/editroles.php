<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
)); ?>

<?php $this->widget('bootstrap.widgets.TbSelect2', array(
    'name' => 'rolesU',        
    'data' => Role::model()->getOptions(),
    'value'=> Role::model()->getOptionsIds($model->id),
    'options' => array(
        'placeholder' => 'Select your Roles...',
        'width' => '40%',
        'tokenSeparators' => array(',', ' '),
    ),
    'htmlOptions'=>array(
        'multiple'=>'multiple',
        'class'=>'controls',
))); ?>

<legend>Links</legend>
    
    <?php echo $form->textFieldRow($profile, 'facebook', array('class'=>'span5')); ?>
    
    <?php echo $form->textFieldRow($profile, 'linkedin', array('class'=>'span5')); ?>
         
    <?php echo $form->textFieldRow($profile, 'twitter', array('class'=>'span5')); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
</div>


<?php $this->endWidget(); ?>
