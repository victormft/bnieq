<?php
		/*$dataProvider=new CActiveDataProvider('Thread', array(
			'criteria'=>array(
			'order'=>'last_post DESC',
    ),));*/
	
$this->renderPartial('//pitch/_profileHeader',array(
		'model'=>$pitch_model,
                'startup_model' => $startup_model,
                'param' => $param
		));
	?>


<?php
/* @var $this ThreadController */
/* @var $model Thread */

$this->breadcrumbs=array(
	'Threads'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Thread', 'url'=>array('index')),
	array('label'=>'Manage Thread', 'url'=>array('admin')),
);
?>

<h1>Create Thread</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'model_post'=>$model_post)); ?>