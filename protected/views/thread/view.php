
<div id="teste2">
<?php
   $this->layout='column1';
/* @var $this ThreadController */
/* @var $model Thread */
/**/
$this->breadcrumbs=array(
	'Threads'=>array('index'),
	$model->title,
);


/*$this->menu=array(
	array('label'=>'List Thread', 'url'=>array('index')),
	array('label'=>'Create Thread', 'url'=>array('create')),
	array('label'=>'Update Thread', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Thread', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Thread', 'url'=>array('admin')),
);*/
?>

<?php /*$this->widget('zii.widgets.CBreadcrumbs', array(
	'links'=>$this->breadcrumbs,
 * 
	));*/?>
    
    <?php 
    $this->renderPartial('//pitch/_profileHeader',array(
		'model'=>$pitch_model,
                'startup_model' => $startup_model,
                'param' => $param
		));
    ?>
	
<h1>Q&A</h1>
<span style="margin: 150px;">
<?php 


$dataProvider=new CActiveDataProvider('Post', array(
    'criteria'=>array(
        'condition'=>'thread_id='.$model->id,
        'order'=>'create_time ASC',
    ),));
	
$postData = $dataProvider->getData();
foreach($postData as $i => $item)
		Yii::app()->controller->renderPartial('_thread',
		array('index' => $i, 'postData' => $item, 'widget' => $this, 'model'=>$model));
		
/*$this->renderPartial('_thread',array(
	'model'=>$model,
	)); */
?>

<?php /*echo CHtml::button('Responder', array('class'=>'thread-reply-button', 
						'submit' => $this->createUrl('post/create',array('threadId'=>$model->id)),
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)
						));*/ ?>
						

						
<?php echo CHtml::link('Responder',array('post/create', 'threadId' => $model->id), array('class' => 'thread-reply-button' ,'id' => 'thread-ajax-post-create'));?>  
  <?php echo CHtml::link('Voltar',array('thread/index', 'startupId' => $startup_model->id), array('class' => 'thread-reply-button' ,'id' => 'thread-ajax-back-index'));?>


<?php /*echo CHtml::button('Voltar', array('class'=>'thread-reply-button', 
						'submit' => $this->createUrl('index'),
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)
						));*/ ?>
<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'replies',
		'views',
		'last_post',
		'title',
		'create_time',
	),
));*/ ?>
<div id = "post-create-wrap"> </div>
</div>

