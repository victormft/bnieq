<?php

$this->menu=array(
    array(
        'label' => 'Startup',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>UserModule::t('Manage Stups'), 'url'=>array('startups')),
    array(
        'label' => 'User',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>'Manage Users', 'url'=>array('/user/admin')),
);
?>

<h1><?php echo  UserModule::t('Update Startup')." ".$model->name; ?></h1>

<?php
	echo $this->renderPartial('_formS', array('model'=>$model));
?>