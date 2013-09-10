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
			var group = (getUrlVars()['group'] == null) ? '' : getUrlVars()['group'];
			
			var n = ($('#n').val()=='') ? '' : '&n='+encodeURIComponent($('#n').val());
			var c_size = ($('#c_size').val()=='') ? '' : '&c_size='+encodeURIComponent($('#c_size').val());
			
			
			var sec=[]; 
			$('input[type=checkbox]:checked').each(function(){
				sec.push($(this).val());
			});
	
			var secs = '';
			
			for (var i = 0, len = sec.length; i < len; i++) {
				secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);
			
			};
			
            location.href = 'startup?group='+group+n+c_size+secs;
});

$('.g').click(function(event) {
			var group = $(this).text();
			var n = (getUrlVars()['n'] == null) ? '' : getUrlVars()['n'];
			var c_size = (getUrlVars()['c_size'] == null) ? '' : getUrlVars()['c_size'];
			
			location.href = 'startup?group='+group+'&n='+n+'&c_size='+c_size+'&sec='+sec;
			
});

$('#yw2').click(function(event) {
			
			location.href = 'startup';
			
});

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$('.sec-label').toggle(function(event) {
		$('#search-sector').css('display', 'block');
		}, function () {
			$('#search-sector').css('display', 'none');
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
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['group']) && $_GET['group']=="Selecionadas") echo 'style="background:#fff; color:#000; font-weight:bold;"'; ?>>Selecionadas</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['group']) && $_GET['group']=="Todas") echo 'style="background:#fff; color:#000; font-weight:bold;"'; ?>>Todas</p></a>
		<p>asdsd</p>
		<p class="last-p">asdsd</p>
	</div>
	
	<div class="form-vertical">
    <?php echo CHtml::beginForm('startup', 'get', array('id'=>'searchform')); ?>


    <div class="row">
        <?php echo CHtml::label('Nome', false); ?>
        
		<div id="search-name">
			<?php echo CHtml::activeTextField($dataProvider,'name', array('name'=>'n')) ?>
			
			<?php	
			$this->widget('bootstrap.widgets.TbButton',array(
				'label' => 'Search',
				'size' => 'small'
			));
			?>
		</div>
		
		<?php echo CHtml::activeLabel($dataProvider,'company_size'); ?>
		
		<?php echo CHtml::activeDropDownList($dataProvider,'company_size', array_merge(array(''=>'Selecione...'), $dataProvider->getCompanySizeOptions()), array('name'=>'c_size')) ?>
		
		 <?php echo CHtml::label('Setores >', false, array('class'=>'sec-label')); ?>
		
		<div id="search-sector">
			<?php echo CHtml::activeCheckBoxList($dataProvider,'sectors', CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'), array('name'=>'sec', 'labelOptions'=>array('style'=>'display:inline'))) ?>
		</div>
	
	
		<?php	
			$this->widget('bootstrap.widgets.TbButton',array(
				'label' => 'Reset',
				'size' => 'small'
			));
			?>
	
	</div>
    <?php echo CHtml::endForm(); ?>
	<!-- form -->
	</div><!-- search-form -->
</div>
