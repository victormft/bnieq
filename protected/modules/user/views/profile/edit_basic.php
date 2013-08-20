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
 
    <?php echo $form->textFieldRow($profile,'firstname'); ?>
	
    <?php echo $form->textFieldRow($profile, 'lastname'); ?>
	
    <?php echo $form->textFieldRow($model, 'username'); ?>
	
	<?php echo $form->textFieldRow($model, 'email', array('append'=>'@')); ?>

    <?php echo $form->datepickerRow($profile, 'birthday', array(
        'append'=>'<i class="icon-calendar"></i>', 
        'options'=>array('format'=>'dd-mm-yyyy'))); ?>	
	
    <?php echo $form->dropDownListRow($profile, 'gender', $profile->getGenderOptions()); ?>
	
	<?php echo $form->textFieldRow($profile, 'telephone'); ?>
	
	<?php echo $form->textFieldRow($profile, 'skype'); ?>
   
	<legend>About you</legend>    
   
    <?php $this->widget('bootstrap.widgets.TbSelect2', array(
        'asDropDownList' => true,
        'name' => 'roles',        
        'data' => array(0=>'clever',1=>'is'),
        'options' => array(
            'placeholder' => 'Select your Roles...',
            'width' => '40%',
            'tokenSeparators' => array(',', ' '),
        ),
        'htmlOptions'=>array(
            'multiple'=>'multiple',
            'class'=>'controlsa',
    ))); ?>
    
		
	<legend>Tags</legend>
 
    <?php $this->widget('bootstrap.widgets.TbTypeahead', array(
		'name'=>'typeahead',		
		'model'=>$profile,
		'attribute'=>'linkedin',
		'options'=>array(
			'source'=>Role::model()->getOptions(),
			//array('Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'),
			'items'=>6,
			'matcher'=>"js:function(item) {
				return ~item.toLowerCase().indexOf(this.query.toLowerCase());
			}",
		),
	)); ?>
     
</fieldset>
 
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
</div>
 
<?php $this->endWidget(); ?>

