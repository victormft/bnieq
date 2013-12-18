<?php

$this->menu=array(
    array(
        'label' => 'Startup',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>'Update Stup', 'url'=>array('updatestartup','id'=>$model->id)),
    array('label'=>'Delete Stup', 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>UserModule::t('Are you sure to delete this item?'))),
    array('label'=>'Manage Stups', 'url'=>array('/user/admin')),    
    //array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array(
        'label' => 'User',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>'Manage Users', 'url'=>array('/user/admin')),
);
?>
<h1><?php echo UserModule::t('View Startup').' "'.$model->name.'"'; ?></h1>

<?php
 
	$attributes = array(
		'id',
		'name',
        'one_line_pitch',
        array(
			'name' => 'selecionada',
			'value' => Startup::itemAlias("StartupSelecionada",$model->selecionada),
		),
        
	);

	
	
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
	

?>
