<?php
$this->layout='column1';
?>



<?php
$this->breadcrumbs=array(
	'Pitches',
);


$this->menu=array(
	array('label'=>'Create Pitch', 'url'=>array('create', 'startupId'=>1)),
	array('label'=>'Delete Pitch', 'url'=>array('delete')),
	array('label'=>'Manage Pitch', 'url'=>array('admin')),
);
?>



<h1 class="create-title" style="margin-top:25px;">Pitches</h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:40px;">Esses são os pitchs em andamento</div>



<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view', //teste
)); ?>
