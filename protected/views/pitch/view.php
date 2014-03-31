<?php
/* @var $this PitchController */
/* @var $model Pitch */
$this->layout='column1';
/*
$this->menu=array(
	array('label'=>'List Pitch', 'url'=>array('index')),
	array('label'=>'Create Pitch', 'url'=>array('create')),
	array('label'=>'Update Pitch', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pitch', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pitch', 'url'=>array('admin')),
);*/
?>


<?php $startup_model = Startup::model()->findByPk($model->startup_id);?>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.carouFredSel-6.2.1.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('follow',
"


$('#follow').click(function(event) {


		if($('#follow').text()=='Follow')
		{	
			$('#follow').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/follow?name=".$startup_model->startupname."',
				type: 'POST',
				data: {
					YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
				},
				dataType: 'json',
				success: function(data){
					$('#follow').removeClass('btn-info');
					$('#follow').removeClass('btn-follow');
					$('#follow').addClass('btn-unfollow');
					$('#follow').text('Unfollow');	
					$('.follow-count').html(data.res);
				}
			});
		}
		
		else if($('#follow').text()=='Unfollow')
		{
			$('#follow').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/unfollow?name=".$startup_model->startupname."',
				type: 'POST',
				data: {
					YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
				},
				dataType: 'json',
				success: function(data){
					$('#follow').addClass('btn-info');
					$('#follow').removeClass('btn-unfollow');
					$('#follow').addClass('btn-follow');
					$('#follow').text('Follow');
					$('.follow-count').html(data.res);					
				}
			});
		}
			
});

/*
$('.chooser').click(function(event){
	var elem = $(this);
	
	if(!elem.hasClass('clicked'))
	{
		$('.profile-column-l-chooser').find('.clicked').removeClass('clicked');
		elem.addClass('clicked');
		
		if(elem.hasClass('activity'))
		{
			if(!elem.hasClass('already-loaded'))
			{
				$('.pitch-ajax-container').css({'opacity':'0.5'});
				var elem = $(this);
				var url_value = 'bnieq/thread/index';//elem.attr('href');
				jQuery.ajax({'url':'".Yii::app()->request->baseUrl."/thread/index','cache':false,
					'success':function(html){
						jQuery('#pitch-ajax-container').html(html)
						//elem.addClass('already-loaded');
					
					}
					});
					return false;
				
				
			}
			else
			{
				$('.profile-column-l').css({'display':'none'});
				$('.profile-column-l-press').css({'display':'none'});
				$('.profile-column-l-activity').css({'display':'block'});
			}
		}
		else if(elem.hasClass('press'))
		{
			if(!elem.hasClass('already-loaded'))
			{
				$('.profile-column-l').css({'opacity':'0.5'});
				$('.profile-column-l-activity').css({'opacity':'0.5'});
				$.ajax({
					url: '".Yii::app()->request->baseUrl."/press/index?startupname=".$startup_model->startupname."&offset=0',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					dataType: 'json',
					success: function(data){
						$('.profile-column-l').css({'display':'none'});
						$('.profile-column-l-activity').css({'display':'none'});
						$('.profile-column-l').css({'opacity':'1'});
						$('.profile-column-l-activity').css({'opacity':'1'});
						$('.pitch-option-container').html(data.res);
						$('.profile-column-l-press').css({'display':'block'});
						//elem.addClass('already-loaded');
					}
				});
			}
			else
			{
				$('.profile-column-l').css({'display':'none'});
				$('.profile-column-l-activity').css({'display':'none'});
				$('.profile-column-l-press').css({'display':'block'});
			}
		}
		else if(elem.hasClass('info'))
		{
			$('.profile-column-l-activity').css({'display':'none'});
			$('.profile-column-l-press').css({'display':'none'});
			$('.profile-column-l').css({'display':'block'});
		}
	}
	
});

$('.profile-column-l-activity').on('click','.more-activities',function(event){
	var elem = $(this);
	var offset = elem.attr('data-offset');
	elem.html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
	$.ajax({
		url: '".Yii::app()->request->baseUrl."/activitystartup/index?startupname=".$startup_model->startupname."&offset='+offset,
		type: 'POST',
		data: {
			YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
		},
		dataType: 'json',
		success: function(data){
			elem.remove();
			$('.content-info-activity').append(data.res);
		},
		error: function(data){
			elem.remove();
			$('.content-info-activity').append('Error');
		}
	});

});

$('.profile-column-l-press').on('click','.more-press',function(event){
	var elem = $(this);
	var offset = elem.attr('data-offset');
	elem.html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
	$.ajax({
		url: '".Yii::app()->request->baseUrl."/press/index?startupname=".$startup_model->startupname."&offset='+offset,
		type: 'POST',
		data: {
			YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
		},
		dataType: 'json',
		success: function(data){
			elem.remove();
			$('.content-info-press').append(data.res);
		},
		error: function(data){
			elem.remove();
			$('.content-info-press').append('Error');
		}
	});

}); */


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

$('.video-images-items').carouFredSel({
	scroll: {
		fx			: 'fade'
	},
		items : 1,
		auto:false,
		pagination: '#video-images-pagination'
	});	

	
	/*******Metodos para chamadas dinamicas dentro da view do pitch **********/
	
		/*metodo para exibir as opções selecionadas*/
	/*jQuery('body').on('click','#pitch-ajax-detail',function(){
	
	
		jQuery.ajax({'url':'".Yii::app()->request->baseUrl."/pitch/detail?name=".$startup_model->startupname."','cache':false,
			'success':function(html){
				var elem = $(this);
				jQuery('.clicked').removeClass('clicked');
				jQuery('.info').addClass('clicked');
				jQuery('#pitch-ajax-container').html(html)
			},
			'error': function(html){
				$('#pitch-ajax-container').append('asdsdsd');
			}
				
		});
		return false;
		}
	);
	
	
	jQuery('body').on('click','#thread-ajax-index',function(){
	
	
		jQuery.ajax({'url':'".Yii::app()->request->baseUrl."/thread/index?startupId=".$model->startup_id."','cache':false,
			'success':function(html){
				jQuery('.clicked').removeClass('clicked');
				jQuery('.activity').addClass('clicked');
				jQuery('#pitch-ajax-container').html(html)
			},
			'error': function(html){
				$('#pitch-ajax-container').append('".Yii::app()->request->baseUrl."/thread/index?startupId=".$model->startup_id."');
			}
				
		});
		return false;
		}
	);*/
	
	
	
		/*******Metodo que chama a listagem de posts da thread **********/
	
        /*        
	jQuery('body').on('click','#thread-ajax-view',function(){
	
	var elem = $(this);
	var url_value = elem.attr('href');
	jQuery.ajax({'url':url_value,'cache':false,'success':function(html){jQuery('#pitch-ajax-container').html(html)}});return false;}
	);
	
		/*******Metodos para criação de novo tópico*********/

	jQuery('body').on('click','#thread-ajax-create',function(){
	
	var elem = $(this);
	var url_value = elem.attr('href');
	jQuery.ajax({'url':'".Yii::app()->request->baseUrl."/thread/create?startupId=".$model->startup_id."','cache':false,'success':function(html){jQuery('#pitch-ajax-container').html(html)}});return false;}
	);
	
	jQuery('body').on('click','#thread-ajax-post-create',function(){
	
	var elem = $(this);
	elem.addClass('clicked');
	var url_value = elem.attr('href');
	jQuery.ajax({'url':url_value,'cache':false,'success':function(html){jQuery('#post-create-wrap').append(html)}});return false;}
	);
	
	jQuery('body').on('click','#thread-ajax-back-index',function(){
	
	var elem = $(this);
	var url_value = elem.attr('href');
	jQuery.ajax({'url':'".Yii::app()->request->baseUrl."/thread/index?startupId=".$model->startup_id."','cache':false,'success':function(html){jQuery('#pitch-ajax-container').html(html)}});return false;}
	);
	*/
	
	/*function sendPostCreateForm()
	{
		 var data=$('#pitch-ajax-container').serialize();
 
 
		$.ajax({
			type: 'POST',
			url: '".Yii::app()->createAbsoluteUrl('post/ajaxCreate')."',
			data:data,
			success:function(data){
                alert(data); 
              },
			error: function(data) { // if error occured
			alert('Error occured.please try again');
			alert(data);
    },
 
		dataType:'html'
	});
 
	}*/
		
");


	
	

?>



<div id = "pitch-ajax-container">

<?php 
    $this->renderPartial('_profileHeader',array(
		'model'=>$model,
                'startup_model' => $startup_model,
                'param' => 'detail'
		));
	
	
    $this->renderPartial('_detail',array(
		'model'=>$model,
		));
	
?>




</div>


<div class="profile-column-l-press">

	<!--<div class="content-wrap">

		<div class="content-head">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i>Press</span>
			<span class="tip">Notícias da Empresa</span>
		</div>
		
		<div class="content-info">
			<div class="content-info-press"></div>
		</div>
		
	</div>	-->
	
	

</div>
<!--<h1>View Pitch #<?php //echo $model->id; ?></h1>-->

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'startup_id',
		'investment_required',
		'equity',
		'video',
		'pitch_text',
		'exit_strategy',
		'create_time',
	),
)); */?>

