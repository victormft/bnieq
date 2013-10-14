<?php

$this->menu=array(
    //array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    //array('label'=>UserModule::t('View User'), 'url'=>array('view','id'=>$model->id)),
    array('label'=>UserModule::t('Manage Stup'), 'url'=>array('startups')),
    array(
        'label' => 'User',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
);
?>

<h1><?php echo  UserModule::t('Update Startup')." ".$model->name; ?></h1>

<?php
	echo $this->renderPartial('_formS', array('model'=>$model));
?>