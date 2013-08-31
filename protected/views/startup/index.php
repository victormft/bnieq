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

$('#searchform').change(function(event) {
			var n = encodeURIComponent($('#n').val());
			var o = $('#o').val();
			var c_size = $('#c_size').val();
            location.href = 'startup?n='+n+'&o='+o+'&c_size='+c_size;
});



");


/*
Yii::app()->clientScript->registerScript('search',
"
$('input[type=text]').keyup(function(){
			
});

$('#searchform').change(function(event) {
            SearchFunc();
            return false;
});

function SearchFunc()   {
    var data = $('input').serialize();
    var url = document.URL;
    var params = $.param(data);
    url = url.substr(0, url.indexOf('?'));
    window.History.pushState(null, document.title,$.param.querystring(encodeURI(url), data));
}
");


*/

/*
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
*/

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

<div class="search-form">
	<?php 
	//$this->renderPartial('_customsearch',array(
	//'dataProvider'=>$dataProvider,
	//)); 
	?>
	
	<div id="G-Selection">
		<div class="group-title">Group Selection</div>
		<span class="group" name="group" value="selecionadas"><p <?php if(isset($_GET['group']) && $_GET['group']=="selecionadas") echo 'style="background:#fff;"'; ?>>Selecionadas</p></span>
		<a href="" onclick="location.href += '?group=todas'; " ><p <?php if(isset($_GET['group']) && $_GET['group']=="todas") echo 'style="background:#fff;"'; ?>>Todas</p></a>
		<p>asdsd</p>
		<p>asdsd</p>
	</div>
	
	<div class="form-vertical">
    <?php echo CHtml::beginForm('startup', 'get', array('id'=>'searchform')); ?>


    <div class="row">
        <?php echo CHtml::activeLabel($dataProvider,'name'); ?>
        
		<?php echo CHtml::activeTextField($dataProvider,'name', array('name'=>'n')) ?>
		
		<?php	
		$this->widget('bootstrap.widgets.TbButton',array(
			'label' => 'Search',
			'size' => 'small'
		));
		?>
		
		<?php echo CHtml::activeLabel($dataProvider,'one_line_pitch'); ?>
		
		<?php echo CHtml::activeTextField($dataProvider,'one_line_pitch', array('name'=>'o')) ?>
		
		<?php echo CHtml::activeLabel($dataProvider,'company_size'); ?>
		
		<?php echo CHtml::activeDropDownList($dataProvider,'company_size', array_merge(array(''=>'Selecione...'), $dataProvider->getCompanySizeOptions()), array('name'=>'c_size')) ?>
		
		<?php echo CHtml::activeLabel($dataProvider,'sectors'); ?>
		
		<?php echo CHtml::activeDropDownList($dataProvider,'sectors', CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'), array('name'=>'sec')) ?>
	
	
	</div>
    <?php echo CHtml::endForm(); ?>
	<!-- form -->
	</div><!-- search-form -->
</div>
