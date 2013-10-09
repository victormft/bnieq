<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");

?>

<div class="spacing-1"></div>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true,
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array(),
    'userComponentId' => 'user',
    'alerts' => array( // configurations per alert type
        // success, info, warning, error or danger
        
        'error' => array('block' => false, 'closeText' => '&times;')
    ),
));?>

<div class="welcome">
    <h1><?php echo UserModule::t("Welcome to NextBlue!"); ?></h1> 
    <h4 style="font-weight: normal;">Login or create an account to continue.</h4>
    
</div>

<div class="login-method align-center">
    <h3 class="align-center gray">Login via Social networks</h3>
    <?php $this->widget('ext.hoauth.widgets.HOAuth'); ?>
</div>

<div class="login-method">
    <h3 class="align-center gray">Login with Email</h3>
    
    <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

    <div class="success">
        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
    </div>

    <?php endif; ?>

    <div class="login-form">
        
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id'=>'login-form',
            'enableClientValidation'=>false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>
        
        <?php echo $form->textFieldRow($login,'username'); ?>
        
        <?php echo $form->passwordFieldRow($login,'password'); ?>     
                
        <div class="row">
            <p class="hint">
            <?php echo CHtml::link(UserModule::t("Lost Password?"),Yii::app()->getModule('user')->recoveryUrl); ?>
            </p>
        </div>
        
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array('buttonType' => 'submit', 'label' => 'Login')
        ); ?>
        
        
        <?php $this->endWidget(); ?>
        <?php unset($form); ?>
        
    </div><!-- form -->

</div>

<div class="login-method">
    <h3 class="align-center gray">Create an account</h3>
    
    <div class="login-form">
        
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id'=>'registration-form',
            'enableClientValidation'=>false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>
        
        <div class="controls form-inline" style="margin-bottom: 10px">
            <label>First &amp; Last names <span class="required">*</span> </label>
            <input style="width: 94px;" name="Profile[firstname]" id="Profile_firstname" type="text" maxlength="50" placeholder="First">
            <input style="width: 94px;" name="Profile[lastname]" id="Profile_lastname" type="text" maxlength="50" placeholder="Last">
            <?php echo $form->error($profile,'firstname', array('style'=>'margin-bottom: 0')); ?>
            <?php echo $form->error($profile,'lastname'); ?>
        </div>
        
        <?php echo $form->textFieldRow($model,'username'); ?>
        
        <?php echo $form->passwordFieldRow($model,'password'); ?>    
        
        <?php echo $form->passwordFieldRow($model,'verifyPassword'); ?>   
        
        <?php echo $form->textFieldRow($model,'email'); ?> 
        
        
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array('buttonType' => 'submit', 'label' => 'Register')
        ); ?>
        
        
        <?php $this->endWidget(); ?>
        <?php unset($form); ?>
        
    </div><!-- form -->
    
</div>

