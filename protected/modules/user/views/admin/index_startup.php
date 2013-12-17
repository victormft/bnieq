<?php

$this->menu=array(
    //array('label'=>UserModule::t('Create'), 'url'=>array('create')),
    //array('label'=>UserModule::t('List User'), 'url'=>array('/user/user')),
    array(
        'label' => 'User',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>'Manage Users', 'url'=>array('/user/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form-admin').toggle();
    return false;
});	
$('.search-form-admin form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

?>
<h1><?php echo UserModule::t("Manage Startups"); ?></h1>

<p><?php echo UserModule::t("You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></p>





<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'startup-grid',
    'type' => 'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			//'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
            'htmlOptions'=>array('style'=>'width: 50px'),
		),
		array(
			'name' => 'name',
			'type'=>'raw',
            'value' => 'CHtml::link(CHtml::encode($data->name),array("/" . $data->startupname))',
			'htmlOptions'=>array('style'=>'width: 150px'),
		),
        'one_line_pitch',
        array(
			'name'=>'selecionada',
			'value'=>'Startup::itemAlias("StartupSelecionada",$data->selecionada)',
			'filter' => Startup::itemAlias("StartupSelecionada"),
            'htmlOptions'=>array('style'=>'width: 50px'),
		),
		array(
            'htmlOptions' => array('nowrap'=>'nowrap'),
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            //'viewButtonUrl'=>'Yii::app()->createUrl("/user/admin/viewstartup", array("id"=>$data->id))',
            'updateButtonUrl'=>'Yii::app()->createUrl("/user/admin/updatestartup", array("id"=>$data->id))',
            'updateButtonOptions'=>array('style'=>'margin-left:8px;'),
            'deleteButtonUrl'=>'Yii::app()->createUrl("/user/admin/deletestartup", array("id"=>$data->id))',
            'deleteButtonOptions'=>array('style'=>'margin-left:8px;'),
        )
	),
)); ?>
