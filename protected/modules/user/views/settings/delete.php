<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Delete Account");

?>

<?php $this->renderPartial('_navigation', array('active'=>'delete')); ?>

<div class="settings-wrap">
    <div class="span8">

        <h1><?php echo UserModule::t("Delete Account"); ?></h1>

        <div class="form">
        <?php $form=$this->beginWidget('TbActiveForm', array(
            'id'=>'delete-form',
            'enableClientValidation'=>false,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
        )); ?>


            <?php echo $form->passwordFieldRow($del,'password'); ?>  


            <div class="row submit">                
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'danger',
                'label'=>'Delete',
                'htmlOptions'=>array('onClick'=>'return confirm("'.UserModule::t("Are you sure?").'\n'.UserModule::t("This action has no return!").'");'),
            )); ?>
            </div>

        <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div>
    
</div>
    
 

