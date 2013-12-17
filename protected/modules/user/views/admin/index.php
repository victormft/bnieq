<?php
Yii::app()->clientScript->registerScript('reports',
"
$(document.body).on('click','.report-modal',function(event){

    var elem = $(this);
    var user_id = encodeURIComponent(elem.attr('data-id'));
    
    var body = elem.find('.modal-body');

    $.ajax({
        url: '".Yii::app()->request->baseUrl."/user/admin/reportpop?id='+user_id,
        type: 'POST',
        data: {
                YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
        },
        dataType: 'json',
        success: function(data){
            body.html(data.res);
        }
    });

			
});
");

$this->menu=array(
    array(
        'label' => 'User',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>'New User', 'url'=>array('create')),
    //array('label'=>UserModule::t('List User'), 'url'=>array('/user/user')),
    array(
        'label' => 'Startup',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>'Manage Stups', 'url'=>array('startups')),
    array(
        'label' => 'Reports',
        'itemOptions' => array('class' => 'nav-header')
    ),
    array('label'=>'REPORTS', 'url'=>array('reports')),
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
<h1><?php echo UserModule::t("Manage Users"); ?></h1>

<p><?php echo UserModule::t("You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></p>

<?php echo CHtml::link(UserModule::t('Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form-admin" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'user-grid',
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
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("/" . $data->username))',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		'create_at',
		'lastvisit_at',
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		),
        
        
        array(
			'name' => 'reports_count',
			'type'=>'raw',
			'value' => function($data){
                return '
                    <div class="report-modal" data-id="'. $data->id .'">
                        <a href="#" data-toggle="modal" data-target="#modal-'. $data->id .'">'. $data->reports_count . ' reports.</a>

                        <!-- Modal -->
                        <div class="modal fade" id="modal-'. $data->id .'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Reports do(a) '. $data->getfullname() .'</h4>
                              </div>
                              <div class="modal-body">

                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div><!-- /.modal-content -->
                          </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>
                ';                    
            },
            'htmlOptions'=>array('style'=>'width: 75px'),
		),
        
        //CHtml::link($data->reports_count . " reports",array("/" . $data->username))
		array(
			'class'=>'CButtonColumn',
            'htmlOptions'=>array('style'=>'width: 55px'),
		),
	),
)); ?>
