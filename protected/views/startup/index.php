<?php
$this->breadcrumbs=array(
	'Startups',
);

$this->menu=array(
array('label'=>'Create Startup','url'=>array('create')),
array('label'=>'Manage Startup','url'=>array('admin')),
);
?>

<h1>Startups</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
