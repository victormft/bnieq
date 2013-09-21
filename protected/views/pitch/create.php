<?php
/* @var $this PitchController */
/* @var $model Pitch */

$this->breadcrumbs=array(
	'Pitches'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pitch', 'url'=>array('index')),
	array('label'=>'Manage Pitch', 'url'=>array('admin')),
);
?>

<h1>Create Pitch</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>