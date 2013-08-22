<?php
$this->layout='column1';

$this->breadcrumbs=array(
	'Startups',
);

$this->menu=array(
array('label'=>'Create Startup','url'=>array('create')),
array('label'=>'Manage Startup','url'=>array('admin')),
);


?>


<?php
Yii::app()->clientScript->registerScript('search',
"
$('input[type=text]').keyup(function(){
   setInterval(function(){
     $(this).closest('form').submit();
      },500);
})

$('#searchform').change(function(event) {
            SearchFunc();
            return false;
});
jQuery('#Startup_name').keydown(function (event) {
    if (event.keyCode && event.keyCode == '13') {
        SearchFunc();
        return false;
    } else {
        return true;
    }
});
function SearchFunc()   {
    var data = $('input').serialize();
    var url = document.URL;
    var params = $.param(data);
    url = url.substr(0, url.indexOf('?'));
    window.History.pushState(null, document.title,$.param.querystring(url, data));
}
");
?>

<h1>Startups</h1>


<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider->search(),
'itemView'=>'_view',
'enableHistory' => TRUE,
'pagerCssClass' => "pagination",
'id'=>'startupslistview',       // must have id corresponding to js above
'template'=>'{items} {pager}',
)); ?>

<div class="search-form" style="float:right;">
	<?php 
	//$this->renderPartial('_customsearch',array(
	//'dataProvider'=>$dataProvider,
	//)); 
	?>
	
	<div class="form-vertical">
    <?php echo CHtml::beginForm('', 'get', array('id'=>'searchform')); ?>


    <div class="row">
        <?php echo CHtml::activeLabel($dataProvider,'name'); ?>
        <?php echo CHtml::activeTextField($dataProvider,'name') ?>
		
		<?php echo CHtml::activeLabel($dataProvider,'one_line_pitch'); ?>
        <?php echo CHtml::activeTextField($dataProvider,'one_line_pitch') ?>
		
		

    <?php echo CHtml::endForm(); ?>
	</div><!-- form -->
	</div><!-- search-form -->
</div>
