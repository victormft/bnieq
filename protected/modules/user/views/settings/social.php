<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Social Networks");
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	UserModule::t("Social Networks"),
);

?>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>true, // whether this is a stacked menu
    'htmlOptions'=>array('style'=>'width:20%; float:left; margin-right:20px'),
    'items'=>array(
        array('label'=>'General', 'url'=>'general'),
        array('label'=>'Password', 'url'=>'password'),
        array('label'=>'Social Networks', 'url'=>'social', 'active'=>true),
    ),
)); ?>

<div class="span8">
    <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="successMessage">
    <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
    <?php endif; ?>

    <h1><?php echo UserModule::t("Social Networks"); ?></h1>
        
    <h4><?php echo UserModule::t("Conectar com:"); ?></h4>
    <?php $this->widget('ext.hoauth.widgets.HOAuth', array('route'=>'user/login')); ?>
    
    <h4><?php echo UserModule::t("Você está conectado com:"); ?></h4>
    <?php $this->widget('ext.hoauth.widgets.HConnectedNetworks'); ?>

</div>
 

