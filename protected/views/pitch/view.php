<?php
/* @var $this PitchController */
/* @var $model Pitch */

$this->layout='column1';
/*
$this->menu=array(
	array('label'=>'List Pitch', 'url'=>array('index')),
	array('label'=>'Create Pitch', 'url'=>array('create')),
	array('label'=>'Update Pitch', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pitch', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pitch', 'url'=>array('admin')),
);*/
?>

<?php 

$this->renderPartial('_detail',array(
	'model'=>$model,
	)); 
?>
<!--<h1>View Pitch #<?php //echo $model->id; ?></h1>-->

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'startup_id',
		'investment_required',
		'equity',
		'video',
		'pitch_text',
		'exit_strategy',
		'create_time',
	),
)); */?>

