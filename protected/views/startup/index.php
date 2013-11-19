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
		$('.sec-arrow').removeClass('arrow-down').addClass('arrow-up');
		$('.sec-label').addClass('clicked').css({'border-bottom':'none'});
		
	}
});


$(document.body).on('click','.follow-press',function(event){

		var startup_name = encodeURIComponent($(this).parent().prev().attr('data-name'));
		var elem = $(this);
		
		if(elem.hasClass('btn-follow'))
		{	
			elem.html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/follow?name='+startup_name,
				type: 'POST',
				dataType: 'json',
				success: function(data){
					elem.removeClass('btn-success');
					elem.removeClass('btn-follow');
					elem.addClass('btn-unfollow');
					elem.text('".UserModule::t('Unfollow')."');	
					elem.parent().prev().html(data.res);
				}
			});
		}
		
		else if(elem.hasClass('btn-unfollow'))
		{
			elem.html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/unfollow?name='+startup_name,
				type: 'POST',
				dataType: 'json',
				success: function(data){
					elem.addClass('btn-success');
					elem.removeClass('btn-unfollow');
					elem.addClass('btn-follow');
					elem.text('".UserModule::t('Follow')."');
					elem.parent().prev().html(data.res);					
				}
			});
		}
			
});


$('#searchform').change(function(event) {
			var g = (getUrlVars()['g'] == null) ? '' : getUrlVars()['g'];
			
			var n = ($('#n').val()=='') ? '' : '&n='+encodeURIComponent($('#n').val().replace(/</g, '').replace(/>/g, ''));
			var c_stage = ($('#c_stage').val()=='') ? '' : '&c_stage='+encodeURIComponent($('#c_stage').val());
			var c = ($('#c').val()=='0') ? '' : '&c='+encodeURIComponent($('#c').val());
			
			
			var sec=[]; 
			$('input[type=checkbox]:checked').each(function(){
				sec.push($(this).val());
			});
	
			var secs = '';
			
			for (var i = 0, len = sec.length; i < len; i++) {
				secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);
			
			};
			
            location.href = 'startup?g='+g+n+c_stage+c+secs;
});

$('.g').click(function(event) {
			var g = $(this).text();
			var n = (getUrlVars()['n'] == null) ? '' : '&n='+getUrlVars()['n'];
			var c_stage = (getUrlVars()['c_stage'] == null) ? '' : '&c_stage='+getUrlVars()['c_stage'];
			var c = (getUrlVars()['c'] == null || getUrlVars()['c']==0) ? '' : '&c='+getUrlVars()['c'];
			
			
			var sec=[]; 
			$('input[type=checkbox]:checked').each(function(){
				sec.push($(this).val());
			});
	
			var secs = '';
			
			for (var i = 0, len = sec.length; i < len; i++) {
				secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);
			
			};
			
			location.href = 'startup?g='+g+n+c_stage+c+secs;
			
});

$('#clean').click(function(event) {
			
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
			$('.sec-arrow').removeClass('arrow-down').addClass('arrow-up');
			$('.sec-label').css({'border-bottom':'none'}).addClass('clicked');
			$('#search-sector').slideDown('slow');
		}
		
		else
		{
			$('#search-sector').slideUp('slow', function(){
				$('.sec-arrow').removeClass('arrow-up').addClass('arrow-down');
				$('.sec-label').css({'border-bottom':'1px solid #ccc'}).removeClass('clicked');
			});
		}
		
});

$('.sec-arrow').click(function(event) {

		if(!$('.sec-arrow').hasClass('arrow-up'))
		{	
			$('.sec-arrow').removeClass('arrow-down').addClass('arrow-up');
			$('.sec-label').addClass('clicked').css({'border-bottom':'none'});
			$('#search-sector').slideDown('slow');
		}
		
		else
		{
			$('#search-sector').slideUp('slow', function(){
				$('.sec-arrow').removeClass('arrow-up').addClass('arrow-down');
				$('.sec-label').removeClass('clicked').css({'border-bottom':'1px solid #ccc'});
			});
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

<div class="sub-header-bg"></div>
<h1 class="create-title" style="margin-top:25px;">Startups</h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:60px;">Confira as empresas cadastradas no NextBlue!</div>


<?php $this->widget('zii.widgets.CListView',array(
'dataProvider'=>$dataProvider->search(),
'itemView'=>'_view',
'id'=>'startupslistview',       // must have id corresponding to js above
'pagerCssClass'=>'pagination',
'pager'=>array('header'=>'', 'hiddenPageCssClass'=>'', 'nextPageLabel'=>'>', 'prevPageLabel'=>'<', 'selectedPageCssClass'=>'active',),
'sorterHeader'=>'',
'sortableAttributes'=>array(
        'create_time',
		'followers_num'
    ),
'template'=>'{summary} {sorter} {items} {pager}',
)); ?>



<div class="search-form">
	<?php 
	//$this->renderPartial('_customsearch',array(
	//'dataProvider'=>$dataProvider,
	//)); 
	?>
	
	<div id="G-Selection">
		<div class="group-title">Busca Rápida</div>
		<a class="g" href="<?php echo Yii::app()->baseUrl.'/startup' ?>"><p <?php if(!isset($_GET['g']) || $_GET['g']=="") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-asterisk profile-icon"></i>Todas</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Selecionadas") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-star profile-icon"></i>Selecionadas</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Populares") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-group profile-icon"></i>Populares</p></a>
		<a class="g" href="javascript:void(0)"><p class="last-p" <?php if(isset($_GET['g']) && $_GET['g']=="Novidades") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-calendar profile-icon"></i>Novidades</p></a>
	</div>
	
	<div class="form-vertical">
    <?php echo CHtml::beginForm('startup', 'get', array('id'=>'searchform')); ?>


    <div class="column">
	
		<div style="margin-bottom:20px;">
			<?php echo CHtml::label('Nome', false); ?>
			
			<div id="search-name">
				<?php echo CHtml::activeTextField($dataProvider,'name', array('name'=>'n')) ?>
				
				<?php	
				$this->widget('bootstrap.widgets.TbButton',array(
					'label' => 'Buscar',
					'size' => 'small',
					'id' => 'search-btn'
				));
				?>
			</div>
		</div>
		
		<div style="margin-bottom:20px;">
			<?php echo CHtml::label('Estágio de Desenvolvimento', false); ?>
			
			<?php echo CHtml::activeDropDownList($dataProvider,'company_stage', array_merge(array(''=>'Selecione...'), $dataProvider->getCompanyStageOptions()), array('name'=>'c_stage', 'style'=>'margin-bottom:0;')) ?>
		</div>
		
		<div style="margin-bottom:20px; position:relative;">
		
			<?php echo CHtml::label('Setores', false, array('class'=>'sec-label')); ?><div class="sec-arrow arrow-down" style="position: absolute; top: 0; margin-left: 50px; margin-top: 8px;"></div>
			
			<div id="search-sector">
				<?php echo CHtml::activeCheckBoxList($dataProvider,'sectors', CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'), array('name'=>'sec', 'labelOptions'=>array('style'=>'display:inline'))) ?>
			</div>
		
		</div>
		
		<div style="margin-bottom:20px;">
			<?php echo CHtml::label('Cidade', false); ?>

			<?php
				$this->widget(
					'bootstrap.widgets.TbSelect2',
					array(
						'attribute' => 'location',
						'model'=>$dataProvider,
						'data' =>array_merge(array('0'=>'Digite o nome da cidade...'),Cidade::model()->getCities()),
						'options'=>array(
							'allowClear'=> true,   
							'dropdownAutoWidth'=> true,
							'minimumInputLength'=> 3,
							'width'=>'240px',
						),
						'htmlOptions'=>array(
							'name'=>'c',
						),
					)
				);
			?>
		</div>
		
	
		<div style="text-align:center;">
		<?php	
			$this->widget('bootstrap.widgets.TbButton',array(
				'label' => 'Limpar',
				'size' => 'normal',
				'id' => 'clean'
			));
			?>
		</div>
	
	</div>
    <?php echo CHtml::endForm(); ?>
	<!-- form -->
	</div><!-- search-form -->
</div>
