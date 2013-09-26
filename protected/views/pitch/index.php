<?php
/* @var $this PitchController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pitches',
);

$this->menu=array(
	array('label'=>'Create Pitch', 'url'=>array('create', 'startupId'=>1)),
	array('label'=>'Manage Pitch', 'url'=>array('admin')),
);
?>

<h1>Pitches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
