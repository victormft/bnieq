<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Social Networks");

?>

<?php $this->renderPartial('_navigation', array('active'=>'social')); ?>

<div class="span8">
    <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="successMessage">
    <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
    <?php endif; ?>

    <h1><?php echo UserModule::t("Social Networks"); ?></h1>
        
    <h4><?php echo UserModule::t("Conectar com:"); ?></h4>
    <?php $this->widget('ext.hoauth.widgets.HOAuth', array('route'=>'user/login')); ?>
    
    <div class="spacing-2"></div>
    
    <h4><?php echo UserModule::t("Você está conectado com:"); ?></h4>
    <?php $this->widget('ext.hoauth.widgets.HConnectedNetworks'); ?>

</div>
 

