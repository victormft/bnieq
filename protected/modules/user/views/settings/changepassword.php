<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");

?>

<?php $this->renderPartial('_navigation', array('active'=>'pass')); ?>

<div class="settings-wrap">
    <div class="span8">
        <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="successMessage">
        <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
        <?php endif; ?>
        
        <?php if($user->password === '' || !isset($user->password)): ?>
        <div class="passwordnull">
            <?php echo 'Sua senha não está definida pois você conectou com uma rede social. Se quiser criar uma senha ' ?>
            <?php EQuickDlgs::ajaxLink(
                    array(
                        'controllerRoute' => 'user/settings/passwordnull',
                        //'actionParams' => array('id'=>$model->id, 'follow'=>'ers', 'attr'=>'follower'),
                        'dialogTitle' => 'Create Password',
                        'dialogWidth' => 400,
                        'dialogHeight' => 400,
                        'openButtonText' => 'clique aqui.',
                        //'closeButtonText' => 'Close', //uncomment to add a closebutton to the dialog
                    )
                ); ?>
        </div>
        <?php endif; ?>

        <h1><?php echo UserModule::t("Change password"); ?></h1>

        <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'changepassword-form',
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>

            <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
            <?php echo $form->errorSummary($model); ?>

            <div class="row">
            <?php echo $form->labelEx($model,'oldPassword'); ?>
            <?php echo $form->passwordField($model,'oldPassword'); ?>
            <?php echo $form->error($model,'oldPassword'); ?>
            </div>

            <div class="row">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?>
            <p class="hint" style="margin-top: -8px">
            <?php echo UserModule::t("Minimal password length 4 symbols."); ?>
            </p>
            </div>

            <div class="row">
            <?php echo $form->labelEx($model,'verifyPassword'); ?>
            <?php echo $form->passwordField($model,'verifyPassword'); ?>
            <?php echo $form->error($model,'verifyPassword'); ?>
            </div>


            <div class="row submit">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>'Salvar',
            )); ?>
            </div>

        <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
</div> 

