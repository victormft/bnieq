<?php
$this->breadcrumbs=array(
	'Startups'=>array('index'),
	$model->name,
);

$this->menu=array(
array('label'=>'List Startup','url'=>array('index')),
array('label'=>'Create Startup','url'=>array('create')),
array('label'=>'Update Startup','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Startup','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Startup','url'=>array('admin')),
);
?>

<h1>View Startup #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'name',
		'logo',
		'one_line_pitch',
		'product_description',
		'company_size',
		'company_stage',
		'foundation',
		'email',
		'telephone',
		'skype',
		'company_number',
		'facebook',
		'twitter',
		'blog',
		'address',
		'client_segment',
		'value_proposition',
		'market_size',
		'sales_marketing',
		'revenue_generation',
		'competitors',
		'competitive_advantage',
		'video',
		'create_time',
),
)); ?>
