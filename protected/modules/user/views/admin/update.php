<?php

$this->menu=array(
    array(
        'label' => 'User',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>'New User', 'url'=>array('create')),
    array('label'=>'View User', 'url'=>array('view','id'=>$model->id)),
    array('label'=>'Manage Users', 'url'=>array('/user/admin')),
    array(
        'label' => 'Startup',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>UserModule::t('Manage Stups'), 'url'=>array('startups')),
);
?>

<h1><?php echo  UserModule::t('Update User')." ".$model->getFullName(); ?></h1>

<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>