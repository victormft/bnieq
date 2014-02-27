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
	jQuery('body').on('click','#pitch-ajax-detail',function(){
	
	
		jQuery.ajax({'url':'".Yii::app()->request->baseUrl."/pitch/detail/".$model->id."','cache':false,
			'success':function(html){
				var elem = $(this);
				jQuery('.clicked').removeClass('clicked');
				jQuery('.info').addClass('clicked');
				jQuery('#pitch-ajax-container').html(html)
			},
			'error': function(html){
				$('.#pitch-ajax-container').append('asdsdsd');
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
				$('.#pitch-ajax-container').append('asdsdsd');
			}
				
		});
		return false;
		}
	);
	
	
	
		/*******Metodo que chama a listagem de posts da thread **********/
		
	jQuery('body').on('click','#thread-ajax-view',function(){
	
	var elem = $(this);
	var url_value = elem.attr('href');
	jQuery.ajax({'url':url_value,'cache':false,'success':function(html){jQuery('#pitch-ajax-container').html(html)}});return false;}
	);
	
		/*******Metodos para criação de novo tópico*********/

	jQuery('body').on('click','#thread-ajax-create',function(){
	
	var elem = $(this);
	var url_value = elem.attr('href');
	jQuery.ajax({'url':url_value,'cache':false,'success':function(html){jQuery('#pitch-ajax-container').html(html)}});return false;}
	);
	
	jQuery('body').on('click','#thread-ajax-post-create',function(){
	
	var elem = $(this);
	elem.addClass('clicked');
	var url_value = elem.attr('href');
	jQuery.ajax({'url':url_value,'cache':false,'success':function(html){jQuery('#pitch-ajax-container').html(html)}});return false;}
	);
	
	jQuery('body').on('click','#thread-ajax-back-index',function(){
	
	var elem = $(this);
	var url_value = elem.attr('href');
	jQuery.ajax({'url':url_value,'cache':false,'success':function(html){jQuery('#pitch-ajax-container').html(html)}});return false;}
	);
		
");


	
	

?>

<div class="profile-header-wrap">
<div class="profile-header">	
	<div id="startup-profile-img">
		<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$startup_model->logo0->name ?>"/>
	</div>
	<div class="profile-header-info">
		
		<div class="profile-name">
			<span><?php echo $startup_model->name; ?></span>
		</div>
		
		<div class="profile-onelinepitch">
			<span style="font-style:italic;"><?php echo $startup_model->one_line_pitch; ?></span>
		</div>
		
		<div class="profile-sectors">
			<span><?php echo $startup_model->getSectorNames(); ?></span>
		</div>
		
		<div class="profile-location">
			<i class="icon-map-marker profile-icon"></i>&nbsp; <?php if (isset($startup_model->city)) echo $startup_model->city->nome; ?>
		</div>
		
		
		<div class="profile-location">
			<i class="icon-circle-blank profile-icon"></i><span>&nbsp; &nbsp;<?php echo 'Equity: ' . $model->equity . '%'; ?></span>
		</div>
		<div class="profile-location">
			<i class="icon-money profile-icon"></i><span>&nbsp; &nbsp;&nbsp;<?php echo 'Meta: R$' . $model->investment_required; ?></span>
		</div>
		<!--
		<div class="profile-links">
			<div class="profile-link">
				<?php if($startup_model->facebook): ?>
					<a href="<?php echo $startup_model->facebook; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png'?>"/></a>
				<?php endif; ?>
			</div>
			<div class="profile-link">
				<?php if($startup_model->twitter): ?>
					<a href="<?php echo $startup_model->twitter; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png'?>"/></a>
				<?php endif; ?>
			</div>
			<div class="profile-link">
				<?php if($startup_model->linkedin): ?>
					<a href="<?php echo $startup_model->linkedin; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png'?>"/></a>
				<?php endif; ?>
			</div>
			<div class="profile-website">
				<i class="icon-globe profile-icon"></i><?php echo $startup_model->website; ?>
			</div>
		</div>
		-->
	</div>
	
	
	<div class="profile-header-right">
		
            <?php if(Yii::app()->user->checkAccess('editStartup', array('startup'=>$startup_model))): ?>
			<span class="edit-btn">			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Editar',
				'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'normal', // null, 'large', 'small' or 'mini'
				'url'=>array('edit','id'=>$model->id),
				'htmlOptions'=>array('style'=>'text-shadow: 1px 1px 1px #555;', /*'class'=>'profile-btn'*/),
					)); 
				?>
			</span>
            <?php endif; ?>
			
			<span class="follow-btn">
			
			
				<div class="follow-info">
					<div class="follow-count"><?php echo count($startup_model->users); ?></div><div class="follow-status">Investidores</div>
				</div>

				<?php 
					
					if(!$startup_model->hasUserFollowing(Yii::app()->user->id))
					{
						$this->widget('bootstrap.widgets.TbButton', array(
						'label'=>'Follow',
                        'id'=>'follow',
						'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						'size'=>'normal', // null, 'large', 'small' or 'mini'
						'url'=>'',//array('follow','name'=>$startup_model->name),
						'htmlOptions'=>array('class'=>'btn-follow'),
						)); 
					}
					
					else
					{
						$this->widget('bootstrap.widgets.TbButton', array(
						'label'=>'Unfollow',
						'id'=>'follow',
						'size'=>'normal', // null, 'large', 'small' or 'mini'
						'url'=>'',//array('unfollow','name'=>$startup_model->name),
						'htmlOptions'=>array('class'=>'btn-unfollow'),
						)); 
					}
					/*
					echo "<button class='btn-msg-wrap' type='button' data-toggle='modal' data-target='#myModal'>";
					$this->widget('bootstrap.widgets.TbButton', array(
						'label'=>'Message',
						'type'=>'warning', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						'size'=>'normal', // null, 'large', 'small' or 'mini'
						'url'=>'',//array('follow','name'=>$startup_model->name),
						'htmlOptions'=>array('style'=>'width:70px; padding:12px 5px;'),
						)); 
					echo "</button>";
					*/
				?>
				
			</span>
			
		
	</div>

</div>


	<div class="profile-column-l-chooser">
		<ul>
			<li class="chooser info clicked" id="pitch-ajax-detail">
				<a href="javascript:void(0)"><?php echo /*UserModule::t('Informations')*/'Detalhes';?></a>
			</li>
			<li class="chooser activity" id="thread-ajax-index">
				<a href="javascript:void(0)"><?php echo /*UserModule::t('Activities')*/'Q&A';?></a>
			</li>
			<li class="chooser press">
				<a href="javascript:void(0)"><?php echo UserModule::t('Press');?></a>
			</li>
	</div>
</div>



<div id = "pitch-ajax-container">

<?php 
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

