<?php
/* @var $this PitchController */
/* @var $model Pitch */

$this->breadcrumbs=array(
	'Pitches'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pitch', 'url'=>array('index')),
	array('label'=>'Create Pitch', 'url'=>array('create')),
	array('label'=>'View Pitch', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pitch', 'url'=>array('admin')),
);
?>

<h1>Update Pitch <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>