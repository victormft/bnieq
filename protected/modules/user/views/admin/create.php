<?php

$this->menu=array(
    array(
        'label' => 'User',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>'Manage Users', 'url'=>array('/user/admin')),
    //array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);
?>
<h1><?php echo UserModule::t("Create User"); ?></h1>

<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>