<?php 

$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);

?>
	
<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
)); ?>

<?php //echo $form->errorSummary(array($model,$profile)); ?>
 
<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<fieldset>
 
    <legend>Basics</legend>
 	
    <?php echo $form->textFieldRow($model, 'username'); ?>
    
    <div class="control-group">
    <?php echo $form->labelEx($profile,'address'); ?>
    <div class="controls">      
        <div class="controls">
            <input name="zipcode" id="zipcode" type="text" maxlength="20">
        </div>
        <?php echo CHtml::ajaxLink('Verificar CEP', array('checkzipcode', 'zipcode'=>'shit'),array(
            'onclick'=>'$("#address").dialog("open"); return false;',
            'update'=>'#address'
            ),array('id'=>'zipCodeChecker'));?>
        <div id="address"></div>
    </div>
    </div>
   
	<legend>About you</legend>   
    
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
    
    <?php $this->widget('bootstrap.widgets.TbSelect2', array(
        
        'name' => 'univerU',        
        'data' => University::model()->getOptions(),
        'value'=> University::model()->getOptionsIds($model->id),
        'options' => array(
            'placeholder' => 'Select your Universities...',
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
    
    
</fieldset>
 
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
</div>
 
<?php $this->endWidget(); ?>


