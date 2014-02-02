






<?php
/* @var $this ThreadController */
/* @var $dataProvider CActiveDataProvider */

/*$this->breadcrumbs=array(
	'Threads',
);

/*$this->menu=array(
	array('label'=>'Create Thread', 'url'=>array('create')),
	array('label'=>'Manage Thread', 'url'=>array('admin')),
);*/
?>

<?php
		/*$dataProvider=new CActiveDataProvider('Thread', array(
			'criteria'=>array(
			'order'=>'last_post DESC',
    ),));*/
	
	?>
<div  id="teste1">
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
		Yii::app()->controller->renderPartial('//thread/_view',
		array('index' => $i, 'data' => $item, 'widget' => $this)); ?>
</div>


		
	<?php /*echo CHtml::button('Novo Tópico', array('class'=>'thread-reply-button', 'id'=>'thread-ajax-create', 
						'submit' => 'thread/create',//$this->createUrl('thread/create'),
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)
						)); 
						*/
			/*echo CHtml::ajaxButton('Novo tópico', 
							array('thread/create'), 
							array('replace'=> '#pitch-ajax-container'), 
							array('class' => 'thread-reply-button',
								   'id' => 'ajax-button-'.uniqid()) 
							 ); */
		echo CHtml::link('Novo tópico',array('thread/create'), array('class' => 'thread-reply-button' ,'id' => 'thread-ajax-create'));
	?>
</div>





<?php /*jQuery('[data-toggle=popover]').popover();
jQuery('body').tooltip({"selector":"[data-toggle=tooltip]"}); 
jQuery('body').on('click','#yt0',function(){jQuery.ajax({'url':'/bnieq/thread/index','cache':false,'success':function(html){jQuery("#teste3").replaceWith(html)}});return false;});

jQuery('body').on('click','#yt1',function(){jQuery.ajax({'url':'/bnieq/post/index','cache':false,'success':function(html){jQuery("#teste3").replaceWith(html)}});return false;});
*/
?>


