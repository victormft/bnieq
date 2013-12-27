<?php
/* @var $this ThreadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Threads',
);

$this->menu=array(
	array('label'=>'Create Thread', 'url'=>array('create')),
	array('label'=>'Manage Thread', 'url'=>array('admin')),
);
?>



<h1>Threads</h1>
<div class="thread-table">
	<div class="thread-heading">
		<div class = "thread-cell">Tópicos</div>  
		<div class = "thread-cell">Autor</div> 
		<div class = "thread-cell">Repostas</div> 
		<div class = "thread-cell">Vizualizações</div> 
		<div class = "thread-cell">Último Post</div>
	</div>
	
	<?php $data = $dataProvider->getData();
	foreach($data as $i => $item)
		Yii::app()->controller->renderPartial('_view',
		array('index' => $i, 'data' => $item, 'widget' => $this));; ?>
</div>


		
	<?php echo CHtml::button('Novo Tópico', array('class'=>'thread-reply-button', 
						'submit' => $this->createUrl('thread/create'),
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)
						)); ?>
	