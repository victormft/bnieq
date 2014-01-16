<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");

?>

<!--<div class="spacing-1"></div>-->


<div class="welcome">
	<div class="sub-header-bg" style="margin-top:-25px; "></div>
    <h1 class="create-title" style="margin-top:25px;"><?php echo UserModule::t("Welcome to NextBlue!"); ?></h1> 
    <div class="create-sub-title" style="font-style:italic; margin-bottom:65px;"><?php echo UserModule::t("Login or create an account to continue."); ?></div>
    
</div>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true,
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array('style'=>'margin: 10px 0;'),
    'userComponentId' => 'user',
    'alerts' => array( // configurations per alert type
        // success, info, warning, error or danger
        
        'error' => array('block' => false, 'closeText' => '&times;')
    ),
));?>

<div class="login-wrap">

	<div class="login-method align-center">
		<h3 class="align-center gray">Login com redes sociais</h3>
		<?php $this->widget('ext.hoauth.widgets.HOAuth'); ?>
	</div>

	<div class="login-method">
		<h3 class="align-center gray">Login com Email</h3>
		
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
			
            <?php echo CHtml::errorSummary($login); ?>
            
			<?php echo $form->textFieldRow($login,'username'); ?>
			
			<?php echo $form->passwordFieldRow($login,'password'); ?>     
					
			<?php if($login->scenario == 'captchaRequired'): ?>
			<div class="row login-captcha">
					<?php echo CHtml::activeLabelEx($login,'verifyCode'); ?>
					<div>
					<?php $this->widget('CCaptcha'); ?>
					<?php echo CHtml::activeTextField($login,'verifyCode'); ?>
					</div>
			</div>
			<?php endif; ?>
			
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
		<h3 class="align-center gray">Crie uma conta</h3>
		
		<div class="login-form">
			
			<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'registration-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>
			
            <?php echo $form->textFieldRow($profile,'firstname'); ?>
            <?php echo $form->textFieldRow($profile,'lastname'); ?>
            
            <!--
			<div class="controls form-inline">
				<label>Nome e sobrenome <span class="required">*</span> </label>
				<input style="width: 94px; margin-bottom: 10px;" name="Profile[firstname]" id="Profile_firstname" type="text" maxlength="50" placeholder="Nome">
				<input style="width: 94px; margin-bottom: 10px;" name="Profile[lastname]" id="Profile_lastname" type="text" maxlength="50" placeholder="Sobrenome">
				<?php if($form->error($profile,'firstname') || $form->error($profile,'lastname')) echo '<span class="help-block error">'.UserModule::t('Required').'</span>' //echo $form->error($profile,'firstname', array('style'=>'display: inline')) . ' | ' . $form->error($profile,'lastname', array('style'=>'display: inline')); ?>				
			</div>
            -->
			
			<?php echo $form->textFieldRow($model,'username'); ?>
			
			<?php echo $form->passwordFieldRow($model,'password'); ?>    
			
			<?php echo $form->passwordFieldRow($model,'verifyPassword'); ?>   
			
			<?php echo $form->textFieldRow($model,'email'); ?> 
                        
            <div style="overflow: auto; margin-bottom: 10px;">
                <label for="RegistrationForm_role" style="display: inline-block">Eu sou</label>
                <span id="RegistrationForm_role" style="display: inline-block; float: right">
                    <input id="ytRegistrationForm_role" type="hidden" name="RegistrationForm[role]">
                    <label class="radio"><input class="form-horizontal" id="RegistrationForm_role_1" value="1" type="radio" name="RegistrationForm[role]">
                        <label for="RegistrationForm_role_1">Investidor</label>                        
                    </label>
                    <label class="radio"><input class="form-horizontal" id="RegistrationForm_role_2" value="2" type="radio" name="RegistrationForm[role]">
                        <label for="RegistrationForm_role_2">Empreendedor</label>                        
                    </label>
                    <label class="radio"><input class="form-horizontal" id="RegistrationForm_role_3" value="3" type="radio" name="RegistrationForm[role]">
                        <label for="RegistrationForm_role_3">Ambos</label></label>
                </span>
            </div>
            
            <?php echo $form->checkboxRow($model, 'newsletter'); ?>
			
			<?php
			$this->widget(
				'bootstrap.widgets.TbButton',
				array('buttonType' => 'submit', 'label' => 'Cadastrar')
			); ?>
			
			
			<?php $this->endWidget(); ?>
			<?php unset($form); ?>
			
		</div><!-- form -->
		
	</div>

</div>
