<?php
$this->breadcrumbs=array(
	'Startups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Startup','url'=>array('index')),
	array('label'=>'Create Startup','url'=>array('create')),
	array('label'=>'View Startup','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Startup','url'=>array('admin')),
	);
	?>

	<h1>Update Startup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>