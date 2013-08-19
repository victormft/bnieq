<?php
$this->breadcrumbs=array(
	'Startups'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List Startup','url'=>array('index')),
array('label'=>'Manage Startup','url'=>array('admin')),
);
?>

<h1>Create Startup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>