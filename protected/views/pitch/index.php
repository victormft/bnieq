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
		$('.sec-label').addClass('clicked');
	}
});




$('#searchform').change(function(event) {
			var g = (getUrlVars()['g'] == null) ? '' : getUrlVars()['g'];
			
			var n = ($('#n').val()=='') ? '' : '&n='+encodeURIComponent($('#n').val());
			var c_stage = ($('#c_stage').val()=='') ? '' : '&c_stage='+encodeURIComponent($('#c_stage').val());
			
			
			var sec=[]; 
			$('input[type=checkbox]:checked').each(function(){
				sec.push($(this).val());
			});
	
			var secs = '';
			
			for (var i = 0, len = sec.length; i < len; i++) {
				secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);
			
			};
			
            location.href = 'pitch?g='+g+n+c_stage+secs;
});

$('.g').click(function(event) {
			var g = $(this).text();
			var n = (getUrlVars()['n'] == null) ? '' : '&n='+getUrlVars()['n'];
			var c_stage = (getUrlVars()['c_stage'] == null) ? '' : '&c_stage='+getUrlVars()['c_stage'];
			
			var sec=[]; 
			$('input[type=checkbox]:checked').each(function(){
				sec.push($(this).val());
			});
	
			var secs = '';
			
			for (var i = 0, len = sec.length; i < len; i++) {
				secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);
			
			};
			
			location.href = 'pitch?g='+g+n+c_stage+secs;
			
});

$('#clean').click(function(event) {
			
			location.href = 'pitch';
			
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
			$('#search-sector').slideDown('slow');
			$('.sec-label').addClass('clicked');
		}
		
		else
		{
			$('#search-sector').slideUp('slow', function(){
				$('.sec-arrow').removeClass('arrow-up').addClass('arrow-down');
			});
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


<h1 class="create-title" style="margin-top:25px;">Pitches</h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:40px;">Esses são os pitchs em andamento</div>




<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider->search(),
	'itemView'=>'_view', //teste
	'id'=>'startupslistview',   
	'pagerCssClass'=>'pagination',
	'pager'=>array('header'=>'', 'hiddenPageCssClass'=>'', 'nextPageLabel'=>'>', 'prevPageLabel'=>'<', 'selectedPageCssClass'=>'active',),
	'sorterHeader'=>'',
	'template'=>'{items} {sorter} {pager}',
	
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
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Novidades") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-calendar profile-icon"></i>Novidades</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Financiada") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-calendar profile-icon"></i>Financiada</p></a>
		<a class="g" href="javascript:void(0)"><p class="last-p" <?php if(isset($_GET['g']) && $_GET['g']=="Seguida") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-calendar profile-icon"></i>Seguida</p></a>
	</div>
	
	<div class="form-vertical">
    <?php echo CHtml::beginForm('pitch', 'get', array('id'=>'searchform')); ?>


    <div class="column">
	
		
		
		<div style="margin-bottom:20px;">
			<?php echo CHtml::label('Investimento mínimo', false); ?>
			
			<div id="search-name">
				<?php echo CHtml::activeTextField($dataProvider,'funded', array('name' => 'n')); ?>
				
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
			
			<?php echo CHtml::activeDropDownList($dataProvider,'funded', array_merge(array(''=>'Selecione...'), Startup::model()->getCompanyStageOptions()), array('name'=>'c_stage', 'style'=>'margin-bottom:0;')) ?>
		</div>
		
		<div style="margin-bottom:20px; position:relative;">
		
			<?php echo CHtml::label('Setores', false, array('class'=>'sec-label')); ?><div class="sec-arrow arrow-down" style="position: absolute; top: 0; margin-left: 50px; margin-top: 8px;"></div>
			
			<div id="search-sector">
				<?php echo CHtml::activeCheckBoxList($dataProvider,'funded', CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'), array('name'=>'sec', 'labelOptions'=>array('style'=>'display:inline'))) ?>
			</div>
		
		</div>
		
		<div style="margin-bottom:20px;">
			<?php echo CHtml::label('Cidade', false); ?>

			<?php
				$this->widget(
					'bootstrap.widgets.TbSelect2',
					array(
						'name' => 'city',
						'model'=>$dataProvider,
						'data' =>array_merge(array('0'=>'Digite o nome da cidade...'),Cidade::model()->getCities()),
						'options'=>array(
							'allowClear'=> true,   
							'dropdownAutoWidth'=> true,
							'minimumInputLength'=> 3,
							'width'=>'240px',
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
