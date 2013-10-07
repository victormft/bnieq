<?php
$this->layout='column1';


?>


<?php
Yii::app()->clientScript->registerScript('search',
"

$(document).ready(function() {
    if(getUrlVars()['sec[0]'])
	{
		$('#search-sector').css('display', 'block');
	}
});

$('#searchform').change(function(event) {
			var g = (getUrlVars()['g'] == null) ? '' : getUrlVars()['g'];
			
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
			
            location.href = 'startup?g='+g+n+c_size+secs;
});

$('.g').click(function(event) {
			var g = $(this).text();
			var n = (getUrlVars()['n'] == null) ? '' : '&n='+getUrlVars()['n'];
			var c_size = (getUrlVars()['c_size'] == null) ? '' : '&c_size='+getUrlVars()['c_size'];
			
			var sec=[]; 
			$('input[type=checkbox]:checked').each(function(){
				sec.push($(this).val());
			});
	
			var secs = '';
			
			for (var i = 0, len = sec.length; i < len; i++) {
				secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);
			
			};
			
			location.href = 'startup?g='+g+n+c_size+secs;
			
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


$('.sec-label').click(function(event) {

		if(!$('.sec-label').hasClass('clicked'))
		{
			$('#search-sector').slideDown('slow');
			$('.sec-label').addClass('clicked');
		}
		
		else
		{
			$('#search-sector').slideUp('slow');
			$('.sec-label').removeClass('clicked');
		}
		
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

<?php $this->widget('zii.widgets.CListView',array(
'dataProvider'=>$dataProvider->search(),
'itemView'=>'_view',
'id'=>'startupslistview',       // must have id corresponding to js above
'pagerCssClass'=>'pagination',
'pager'=>array('header'=>'', 'hiddenPageCssClass'=>'', 'nextPageLabel'=>'>', 'prevPageLabel'=>'<', 'selectedPageCssClass'=>'active',),
'sorterHeader'=>'Ordenar por: ',
'sortableAttributes'=>array(
        'name',
		'followers_num'
    ),
'template'=>'{sorter} {items} {pager}',
)); ?>



<div class="search-form">
	<?php 
	//$this->renderPartial('_customsearch',array(
	//'dataProvider'=>$dataProvider,
	//)); 
	?>
	
	<div id="G-Selection">
		<div class="group-title">Busca Rápida</div>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Selecionadas") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-star profile-icon"></i>Selecionadas</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Populares") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-group profile-icon"></i>Populares</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Novidades") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-calendar profile-icon"></i>Novidades</p></a>
		<a class="g" href="javascript:void(0)"><p class="last-p" <?php if(isset($_GET['g']) && $_GET['g']=="Todas") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-asterisk profile-icon"></i>Todas</p></a>
	</div>
	
	<div class="form-vertical">
    <?php echo CHtml::beginForm('startup', 'get', array('id'=>'searchform')); ?>


    <div class="row">
        <?php echo CHtml::label('Nome', false); ?>
        
		<div id="search-name">
			<?php echo CHtml::activeTextField($dataProvider,'name', array('name'=>'n')) ?>
			
			<?php	
			$this->widget('bootstrap.widgets.TbButton',array(
				'label' => 'Buscar',
				'size' => 'small'
			));
			?>
		</div>
		
		<?php echo CHtml::activeLabel($dataProvider,'company_size'); ?>
		
		<?php echo CHtml::activeDropDownList($dataProvider,'company_size', array_merge(array(''=>'Selecione...'), $dataProvider->getCompanySizeOptions()), array('name'=>'c_size')) ?>
		
		<div>
		
		<?php echo CHtml::label('Setores >', false, array('class'=>'sec-label')); ?>
		
		<div id="search-sector">
			<?php echo CHtml::activeCheckBoxList($dataProvider,'sectors', CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'), array('name'=>'sec', 'labelOptions'=>array('style'=>'display:inline'))) ?>
		</div>
		
		</div>
	
		<div>
		<?php	
			$this->widget('bootstrap.widgets.TbButton',array(
				'label' => 'Limpar',
				'size' => 'small'
			));
			?>
		</div>
	
	</div>
    <?php echo CHtml::endForm(); ?>
	<!-- form -->
	</div><!-- search-form -->
</div>
