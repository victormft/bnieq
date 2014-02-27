<?php
$this->layout='column1';
?>


<?php
/* @var $this PitchController */
/* @var $model Pitch */
/*
$this->breadcrumbs=array(
	'Pitches'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pitch', 'url'=>array('index')),
	array('label'=>'Manage Pitch', 'url'=>array('admin')),
);*/
?>

<!-- modificar depois, foi só um teste utilizando algumas classes do css da startup -->
<h1 class="create-title">Criar Pitch</h1>
<div class="create-sub-title" style="font-style:italic;">Forneça os dados para a criação do Pitch!</div>


<div class="create-wrap">
<?php $this->renderPartial('_form', array('model'=>$model, 'profile'=>$profile, 'startup'=>$startup)); ?>
</div>

