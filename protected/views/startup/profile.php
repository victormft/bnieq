<?php
$this->layout='column1';
?>

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.carouFredSel-6.2.1.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('follow',
"


$('#follow').click(function(event) {


		if($('#follow').text()=='Follow')
		{	
			$('#follow').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/follow?name=".$model->startupname."',
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
				url: '".Yii::app()->request->baseUrl."/startup/unfollow?name=".$model->startupname."',
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
				$('.profile-column-l').css({'opacity':'0.5'});
				$('.profile-column-l-press').css({'opacity':'0.5'});
				$('.profile-column-l-update').css({'opacity':'0.5'});
                $('.profile-column-l-comment').css({'opacity':'0.5'});
				$.ajax({
					url: '".Yii::app()->request->baseUrl."/activitystartup/index?startupname=".$model->startupname."&offset=0',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					dataType: 'json',
					success: function(data){
						$('.profile-column-l').css({'display':'none'});
						$('.profile-column-l-press').css({'display':'none'});
						$('.profile-column-l-update').css({'display':'none'});
                        $('.profile-column-l-comment').css({'display':'none'});
						$('.profile-column-l').css({'opacity':'1'});
						$('.profile-column-l-press').css({'opacity':'1'});
						$('.profile-column-l-update').css({'opacity':'1'});
                        $('.profile-column-l-comment').css({'opacity':'1'});
						$('.content-info-activity').html(data.res);
						$('.profile-column-l-activity').css({'display':'block'});
						elem.addClass('already-loaded');
					}
				});
			}
			else
			{
				$('.profile-column-l').css({'display':'none'});
				$('.profile-column-l-press').css({'display':'none'});
				$('.profile-column-l-update').css({'display':'none'});
                $('.profile-column-l-comment').css({'display':'none'});
				$('.profile-column-l-activity').css({'display':'block'});
			}
		}
		else if(elem.hasClass('press'))
		{
			if(!elem.hasClass('already-loaded'))
			{
				$('.profile-column-l').css({'opacity':'0.5'});
				$('.profile-column-l-activity').css({'opacity':'0.5'});
				$('.profile-column-l-update').css({'opacity':'0.5'});
                $('.profile-column-l-comment').css({'opacity':'0.5'});
				$.ajax({
					url: '".Yii::app()->request->baseUrl."/press/index?startupname=".$model->startupname."&offset=0',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					dataType: 'json',
					success: function(data){
						$('.profile-column-l').css({'display':'none'});
						$('.profile-column-l-activity').css({'display':'none'});
						$('.profile-column-l-update').css({'display':'none'});
                        $('.profile-column-l-comment').css({'display':'none'});
						$('.profile-column-l').css({'opacity':'1'});
						$('.profile-column-l-activity').css({'opacity':'1'});
						$('.profile-column-l-update').css({'opacity':'1'});
                        $('.profile-column-l-comment').css({'opacity':'1'});
						$('.content-info-press').html(data.res);
						$('.profile-column-l-press').css({'display':'block'});
						elem.addClass('already-loaded');
					}
				});
			}
			else
			{
				$('.profile-column-l').css({'display':'none'});
				$('.profile-column-l-activity').css({'display':'none'});
				$('.profile-column-l-update').css({'display':'none'});
                $('.profile-column-l-comment').css({'display':'none'});
				$('.profile-column-l-press').css({'display':'block'});
			}
		}
		else if(elem.hasClass('update'))
		{
			if(!elem.hasClass('already-loaded'))
			{
				$('.profile-column-l').css({'opacity':'0.5'});
				$('.profile-column-l-activity').css({'opacity':'0.5'});
				$('.profile-column-l-press').css({'opacity':'0.5'});
                $('.profile-column-l-comment').css({'opacity':'0.5'});
				$.ajax({
					url: '".Yii::app()->request->baseUrl."/startupupdate/index?startupname=".$model->startupname."&offset=0',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					dataType: 'json',
					success: function(data){
						$('.profile-column-l').css({'display':'none'});
						$('.profile-column-l-activity').css({'display':'none'});
						$('.profile-column-l-press').css({'display':'none'});
                        $('.profile-column-l-comment').css({'display':'none'});
						$('.profile-column-l').css({'opacity':'1'});
						$('.profile-column-l-activity').css({'opacity':'1'});
						$('.profile-column-l-press').css({'opacity':'1'});
                        $('.profile-column-l-comment').css({'opacity':'1'});
						$('.content-info-update').html(data.res);
						$('.profile-column-l-update').css({'display':'block'});
						elem.addClass('already-loaded');
					}
				});
			}
			else
			{
				$('.profile-column-l').css({'display':'none'});
				$('.profile-column-l-activity').css({'display':'none'});
				$('.profile-column-l-press').css({'display':'none'});
                $('.profile-column-l-comment').css({'display':'none'});
				$('.profile-column-l-update').css({'display':'block'});
			}
		}
		else if(elem.hasClass('comment'))
		{
			if(!elem.hasClass('already-loaded'))
			{
				$('.profile-column-l').css({'opacity':'0.5'});
				$('.profile-column-l-activity').css({'opacity':'0.5'});
				$('.profile-column-l-press').css({'opacity':'0.5'});
                $('.profile-column-l-update').css({'opacity':'0.5'});
				$.ajax({
					url: '".Yii::app()->request->baseUrl."/startupcomment/index?startupname=".$model->startupname."&offset=0',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					dataType: 'json',
					success: function(data){
						$('.profile-column-l').css({'display':'none'});
						$('.profile-column-l-activity').css({'display':'none'});
						$('.profile-column-l-press').css({'display':'none'});
                        $('.profile-column-l-update').css({'display':'none'});
						$('.profile-column-l').css({'opacity':'1'});
						$('.profile-column-l-activity').css({'opacity':'1'});
						$('.profile-column-l-press').css({'opacity':'1'});
                        $('.profile-column-l-update').css({'opacity':'1'});
						$('.content-info-comment').html(data.res);
						$('.profile-column-l-comment').css({'display':'block'});
						elem.addClass('already-loaded');
					}
				});
			}
			else
			{
				$('.profile-column-l').css({'display':'none'});
				$('.profile-column-l-activity').css({'display':'none'});
				$('.profile-column-l-press').css({'display':'none'});
                $('.profile-column-l-update').css({'display':'none'});
				$('.profile-column-l-comment').css({'display':'block'});
			}
			
		}
		else if(elem.hasClass('info'))
		{
			$('.profile-column-l-activity').css({'display':'none'});
			$('.profile-column-l-press').css({'display':'none'});
			$('.profile-column-l-update').css({'display':'none'});
            $('.profile-column-l-comment').css({'display':'none'});
			$('.profile-column-l').css({'display':'block'});
		}
	}
	
});

$('.profile-column-l-activity').on('click', '.press-link', function(event){
	
	$('.clicked').removeClass('clicked');
	$('.press').addClass('clicked');
	if(!$('.press').hasClass('already-loaded'))
	{
		$('.profile-column-l-activity').css({'opacity':'0.5'});
		$.ajax({
			url: '".Yii::app()->request->baseUrl."/press/index?startupname=".$model->startupname."&offset=0',
			type: 'POST',
			data: {
				YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
			},
			dataType: 'json',
			success: function(data){
				$('.profile-column-l-activity').css({'display':'none'});
				$('.profile-column-l-activity').css({'opacity':'1'});
				$('.content-info-press').html(data.res);
				$('.profile-column-l-press').css({'display':'block'});
				$('.press').addClass('already-loaded');
			}
		});
	}
	else
	{
		$('.profile-column-l-activity').css({'display':'none'});
		$('.profile-column-l-press').css({'display':'block'});
	}

});

$('.profile-column-l-activity').on('click', '.update-link', function(event){
	
	$('.clicked').removeClass('clicked');
	$('.update').addClass('clicked');
	if(!$('.update').hasClass('already-loaded'))
	{
		$('.profile-column-l-activity').css({'opacity':'0.5'});
		$.ajax({
			url: '".Yii::app()->request->baseUrl."/startupupdate/index?startupname=".$model->startupname."&offset=0',
			type: 'POST',
			data: {
				YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
			},
			dataType: 'json',
			success: function(data){
				$('.profile-column-l-activity').css({'display':'none'});
				$('.profile-column-l-activity').css({'opacity':'1'});
				$('.content-info-update').html(data.res);
				$('.profile-column-l-update').css({'display':'block'});
				$('.update').addClass('already-loaded');
			}
		});
	}
	else
	{
		$('.profile-column-l-activity').css({'display':'none'});
		$('.profile-column-l-update').css({'display':'block'});
	}

});

$('.profile-column-l-activity').on('click','.more-activities',function(event){
	var elem = $(this);
	var offset = elem.attr('data-offset');
	elem.html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
	$.ajax({
		url: '".Yii::app()->request->baseUrl."/activitystartup/index?startupname=".$model->startupname."&offset='+offset,
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
		url: '".Yii::app()->request->baseUrl."/press/index?startupname=".$model->startupname."&offset='+offset,
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

});

$('.profile-column-l-update').on('click','.more-update',function(event){
	var elem = $(this);
	var offset = elem.attr('data-offset');
	elem.html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
	$.ajax({
		url: '".Yii::app()->request->baseUrl."/startupupdate/index?startupname=".$model->startupname."&offset='+offset,
		type: 'POST',
		data: {
			YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
		},
		dataType: 'json',
		success: function(data){
			elem.remove();
			$('.content-info-update').append(data.res);
		},
		error: function(data){
			elem.remove();
			$('.content-info-update').append('Error');
		}
	});

});

$('.profile-column-l-comment').on('click','.more-comment',function(event){
	var elem = $(this);
	var offset = elem.attr('data-offset');
	elem.html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
	$.ajax({
		url: '".Yii::app()->request->baseUrl."/startupcomment/index?startupname=".$model->startupname."&offset='+offset,
		type: 'POST',
		data: {
			YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
		},
		dataType: 'json',
		success: function(data){
			elem.remove();
			$('.content-info-comment').append(data.res);
		},
		error: function(data){
			elem.remove();
			$('.content-info-comment').append('Error');
		}
	});

});

$('#form-comment').submit(function(event) {
		
		event.preventDefault(); 
		$('.comment-btn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/addComment?name=".$model->startupname."',
				dataType: 'json',
				type: 'POST',
				data: $('#form-comment').serialize(),
				success: function(data){
					if(data.res=='no')
					{
						$('#form-comment').find('.comment-error').html(data.msg);
						$('.comment-btn').text('Post');
					}
					else
					{
						$('.content-info-comment').prepend(data.res);
						$('.comment-wrap').show('slow').animate({opacity: 1}, 250);
						$('.comment-error').html('');			
						$('.comment-btn').text('Post');
					}
				}
			});
		
		
});

$('.content-info-comment').on('click','.comment-delete',function(event){
		if(confirm('Are you sure?'))
		{
			var parent = $(this).parent();
			var id = parent.find('.notif-image').attr('data-id');
			parent.addClass('deletable');
			$.ajax({
					url: '".Yii::app()->request->baseUrl."/startup/deleteComment?id='+id+'&name=".$model->startupname."',
					dataType: 'json',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					success: function(data){
						
						if(data.res=='OK')
							$('.deletable').animate({opacity: 0}, 100).hide('slow', function(){ $('.deletable').remove(); });
						
						else
						{
							$('.deletable').removeClass('deletable');	
							parent.find('.traction-error').html(data.msg);
						}					
						
					},
					error: function(){
						$('.deletable').removeClass('deletable');	
					}
				});
		}
	
});

	$('.content-info-comment').on('mouseover','.comment-wrap',function(event){
		$(this).find('.comment-delete').css({'color':'red', 'font-size':'22px'});	
	});
	
	$('.content-info-comment').on('mouseout','.comment-wrap',function(event){
		$(this).find('.comment-delete').css({'color':'#ccc', 'font-size':'15px'});	
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

$('.video-images-items').carouFredSel({
	scroll: {
		fx			: 'fade'
	},
		items : 1,
		auto:false,
		pagination: '#video-images-pagination'
	});	

");

?>

<div class="profile-header-wrap">
	<div class="profile-header">	
		<div id="startup-profile-img" style="background-image:url(<?php echo 'http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$model->logo0->name; ?>); background-size:cover; background-position: 50% 50%;"></div>
		
		<div class="profile-header-info">
			
			<div class="profile-name">
				<span><?php echo CHtml::encode($model->name); ?></span>
			</div>
			
			<div class="profile-onelinepitch">
				<span style="font-style:italic;"><?php echo CHtml::encode($model->one_line_pitch); ?></span>
			</div>
			
			<div class="profile-sectors">
				<span><?php echo $model->getSectorNames(); ?></span>
			</div>
			
			<div class="profile-location">
				<i class="icon-map-marker profile-icon"></i><?php if (isset($model->city)) echo CHtml::encode($model->city->nome); ?>
			</div>
			
			<!--
			<div class="profile-links">
				<div class="profile-link">
					<?php if($model->facebook): ?>
						<a href="<?php echo $model->facebook; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png'?>"/></a>
					<?php endif; ?>
				</div>
				<div class="profile-link">
					<?php if($model->twitter): ?>
						<a href="<?php echo $model->twitter; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png'?>"/></a>
					<?php endif; ?>
				</div>
				<div class="profile-link">
					<?php if($model->linkedin): ?>
						<a href="<?php echo $model->linkedin; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png'?>"/></a>
					<?php endif; ?>
				</div>
				<div class="profile-website">
					<i class="icon-globe profile-icon"></i><?php echo $model->website; ?>
				</div>
			</div>
			-->
		</div>
		
		
		<div class="profile-header-right">
			
				<?php if(Yii::app()->user->checkAccess('editStartup', array('startup'=>$model))): ?>
				<span class="edit-btn">			
					<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Editar',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('edit/'.$model->startupname),
					'htmlOptions'=>array('style'=>'text-shadow: 1px 1px 1px #555;', /*'class'=>'profile-btn'*/),
						)); 
					?>
				</span>
				<?php endif; ?>
				
				<span class="follow-btn">
				
				
					<div class="follow-info">
						
						
						<?php EQuickDlgs::ajaxLink(
						array(
							'controllerRoute' => 'startup/followpop',
							'actionParams' => array('id'=>$model->id),
							'dialogTitle' => UserModule::t('Followers'),
							'dialogWidth' => 600,
							'dialogHeight' => 500,
							'openButtonText' => '<div class="follow-count">'.count($model->users).'</div><div class="follow-status">'.UserModule::t('Followers').'</div>',
							//'closeButtonText' => 'Close', //uncomment to add a closebutton to the dialog
						)
						);?>
						
						
						
					</div>

					<?php 
						
						if(!$model->hasUserFollowing(Yii::app()->user->id))
						{
							$this->widget('bootstrap.widgets.TbButton', array(
							'label'=>'Follow',
							'id'=>'follow',
							'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
							'size'=>'normal', // null, 'large', 'small' or 'mini'
							'url'=>'',//array('follow','name'=>$model->name),
							'htmlOptions'=>array('class'=>'btn-follow'),
							)); 
						}
						
						else
						{
							$this->widget('bootstrap.widgets.TbButton', array(
							'label'=>'Unfollow',
							'id'=>'follow',
							'size'=>'normal', // null, 'large', 'small' or 'mini'
							'url'=>'',//array('unfollow','name'=>$model->name),
							'htmlOptions'=>array('class'=>'btn-unfollow'),
							)); 
						}
						/*
						echo "<button class='btn-msg-wrap' type='button' data-toggle='modal' data-target='#myModal'>";
						$this->widget('bootstrap.widgets.TbButton', array(
							'label'=>'Message',
							'type'=>'warning', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
							'size'=>'normal', // null, 'large', 'small' or 'mini'
							'url'=>'',//array('follow','name'=>$model->name),
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
			<li class="chooser info clicked">
				<a href="javascript:void(0)"><?php echo UserModule::t('Informations');?></a>
			</li>
			<li class="chooser activity" style="width:140px;">
				<a href="javascript:void(0)"><?php echo UserModule::t('Activities');?><?php if($model->activities): ?><span style="margin-left:10px; padding:2px 4px; border:1px solid #ccc;"><?php echo count($model->activities); endif; ?></a>
			</li>
			<li class="chooser press">
				<a href="javascript:void(0)"><?php echo UserModule::t('Press');?><?php if($model->press): ?><span style="margin-left:10px; padding:2px 4px; border:1px solid #ccc;"><?php echo count($model->press); endif; ?></a>
			</li>
			<li class="chooser update">
				<a href="javascript:void(0)">Update<?php if($model->update): ?><span style="margin-left:10px; padding:2px 4px; border:1px solid #ccc;"><?php echo count($model->update);  endif;?></span></a>
			</li>
			<li class="chooser comment">
				<a href="javascript:void(0)">Comments</a>
			</li>
		</ul>
		
	</div>
	
</div>
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i>O Produto</span>
			<span class="tip">Entenda qual a solução proposta pela nossa Empresa</span>
		</div>
		
		<div class="content-info">
			<?php echo CHtml::encode($model->product_description);?> 		
		</div>
		
	</div>	
	
	<?php if($model->video || $model->images):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-picture profile-icon-vid"></i>Video & Imagens
			<span class="tip">Video e Fotos sobre a Empresa e nosso Produto</span>
		</div>
		
		<div class="content-info video-images">
			<div class="video-images-items">
				<?php if($model->video){$this->widget('ext.Yiitube', array('size' => 'small', 'v' => CHtml::encode($model->video)));} ?>	
				<?php foreach($model->images as $img) :?>
					<div style="float:left; width: 500px; height:312px; line-height:300px; text-align:center;">
						<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$img->name ?>" id="generic-img" alt="asdasd" style="vertical-align:middle; max-width:500px; max-height:312px;"/>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="pagination carousel-pag" id="video-images-pagination"></div>
		</div>
		
	</div>	
	<?php endif;?>
	
	
	<?php if($model->tech):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-cogs profile-icon"></i> Tecnologia
			<span class="tip">Tecnologia que utilizamos em nosso Produto</span>
		</div>
		
		<div class="content-info">
			
			<?php echo CHtml::encode($model->tech);?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->client_segment):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-screenshot profile-icon"></i> Público Alvo
			<span class="tip">Pessoas a quem se destina nosso Produto</span>
		</div>
		
		<div class="content-info">
			
			<?php echo CHtml::encode($model->client_segment);?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->revenue_generation):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-money profile-icon"></i> Geração de Renda
			<span class="tip">Como nosso empresa gera renda</span>
		</div>
		
		<div class="content-info">
			
			<?php echo CHtml::encode($model->revenue_generation);?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->competitors):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-warning-sign profile-icon"></i> Principais Concorrentes
			<span class="tip">Os maiores players no mercado em que atuamos</span>
		</div>
		
		<div class="content-info">
			
			<?php echo CHtml::encode($model->competitors);?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->competitive_advantage):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-trophy profile-icon"></i> Vantagem Competitiva
			<span class="tip">O diferencial da nossa empresa</span>
		</div>
		
		<div class="content-info">
			
			<?php echo CHtml::encode($model->competitive_advantage);?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->history):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-book profile-icon"></i> História da Empresa
			<span class="tip">Nossa história até o momento</span>
		</div>
		
		<div class="content-info">
			
			<?php echo CHtml::encode($model->history);?> 
			
		</div>
		
	</div>
	<?php endif;?>
	
	<?php if($model->traction):?>
	<div class="content-wrap">

		<div class="content-head" id="traction">
			<i class="icon-book profile-icon"></i> Traction
			<span class="tip">Metas de desempenho da empresa</span>
		</div>
		
		<div class="content-info">
			
			<?php if(Yii::app()->user->isGuest): ?>
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			<?php else: ?>
				<table>
				<tr class="table-header" style="font-weight:bold;">
					<td>Métrica</td>
					<td>Valor</td>
					<td>Período</td>
					<td>Data</td>
				</tr>
				<?php 
					$qry = new CDbCriteria(array(
						'condition' => "startup_id=:param",
						'order' => "date DESC",
						'params' => array(':param' => $model->id),  
					));

					$query = Traction::model()->findAll($qry); 
					
					foreach($query as $traction):  
				?>		
				<tr>		
					<td><div class="tracion-metric"><?php echo CHtml::encode($traction->metric); ?></div></td>
					<td><div class="traction-value"><?php echo CHtml::encode($traction->value); ?></div></td>
					<td><div class="traction-period"><?php echo CHtml::encode($traction->period);?></div></td>
					<td><div class="traction-date"><?php echo date('d/m/y', strtotime(CHtml::encode($traction->date))); ?></div></td>
				</tr>
				<?php endforeach;?>
				</table>
			<?php endif;?>
		</div>
		
	</div>
	<?php endif;?>
	
	
	<?php if($model->past):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-book profile-icon"></i> Past Investments
			<span class="tip">Investimentos anteriores na empresa</span>
		</div>
		
		<div class="content-info">
		<?php if(Yii::app()->user->isGuest): ?>
			<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
			<p style="text-align:center;">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Login',
				'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'normal', // null, 'large', 'small' or 'mini'
				'url'=>array('/user/login'),
				)); 
			?>
			</p>
		<?php else: ?>	
			<table>
			<tr class="table-header" style="font-weight:bold;">
				<td>Investidor</td>
				<td>Valor</td>
				<td>Data</td>
			</tr>
			<?php 
				$qry = new CDbCriteria(array(
					'condition' => "startup_id=:param",
					'order' => "date DESC",
					'params' => array(':param' => $model->id),  
				));

				$query = PastInvestment::model()->findAll($qry); 
				
				foreach($query as $past):  
			?>		
			<tr>		
				<?php if(empty($past->user_id)):?>
					<td>
						<div class="past-image"><?php echo '<img src="'.Yii::app()->request->baseUrl.'/images/default-user.png" id="past-img" />'; ?></div>
						<div class="past-investor"><span data-id="<?php echo CHtml::encode($past->id); ?>"><?php echo CHtml::encode($past->investor_name); ?></div></td>
					</td>
				<?php else:?>
					<?php $usr=User::model()->find('user_id=:u_id', array(':u_id'=>$past->user_id)); ?>
					<td>
						<div class="past-image"><?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$usr->profile->logo->name.'" id="past-img" />', array('/' . $usr->username)); ?></div>
						<div class="past-investor"><span data-id="<?php echo CHtml::encode($past->id); ?>"><?php echo CHtml::link(CHtml::encode($usr->getFullName()), array('/' . $usr->username)); ?></div></td>
					</td>
				<?php endif;?>
				<td><div class="past-value"><?php echo CHtml::encode($past->value); ?></div></td>
				<td><div class="past-date"><?php echo date('d/m/y', strtotime(CHtml::encode($past->date))); ?></div></td>
			</tr>
			<?php endforeach;?>
			</table>
		<?php endif; ?>	
		</div>
		
	</div>
	<?php endif;?>
	

</div>

<div class="profile-column-l-activity">

	<div class="content-wrap">

		<div class="content-head">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i>Activities</span>
			<span class="tip">Atividades recentes da Empresa</span>
		</div>
		
		<div class="content-info">
			<div class="content-info-activity"></div>
		</div>
		
	</div>	

</div>

<div class="profile-column-l-press">

	<div class="content-wrap">

		<div class="content-head" id="press">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i>Press</span>
			<span class="tip">Notícias da Empresa</span>
		</div>
		
		<div class="content-info">
			<div class="content-info-press"></div>
		</div>
		
	</div>	

</div>

<div class="profile-column-l-update">

	<div class="content-wrap">

		<div class="content-head" id="update">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i>Update</span>
			<span class="tip">Atualizações da empresa</span>
		</div>
		
		<div class="content-info">
			<div class="content-info-update"></div>
		</div>
		
	</div>	

</div>

<div class="profile-column-l-comment">

	<div class="content-wrap">

		<div class="content-head" id="comment">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i>Comment</span>
			<span class="tip">Comentários sobre a empresa</span>
		</div>
		
		<div class="content-info">
			
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'form-comment',
					'action'=>'',
					'htmlOptions' => array('enctype' => 'multipart/form-data'), 
				)); ?>
		
					<?php echo CHtml::label('Text', false, array('style'=>'display:block; margin-right:30px;')); ?>
					<?php echo CHtml::textField('text'); ?>
					
			
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'label'=>'Post',
						'size'=>'normal',
						'htmlOptions'=>array(
							'style'=>'display:block; width:65px;',
							'class'=>'comment-btn btn-primary',
							),
						)); 
					?>
					<div class="comment-error" style="display:inline; margin-left:10px; color:#b94a48;"></div>
			
				<?php $this->endWidget(); ?>
			
			<div class="content-info-comment"></div>
		</div>
		
	</div>	

</div>

<div class="profile-column-r">
	
	<?php if($model->facebook || $model->twitter || $model->linkedin || $model->website):?>
	<div class="content-wrap">

		<div class="content-head rounded social-web">
			<div class="profile-links">
				<div class="profile-link">
					<?php if($model->facebook): ?>
						<a href="<?php if(strpos($model->facebook, 'http')!==false){ echo CHtml::encode($model->facebook);} else {echo 'http://'.CHtml::encode($model->facebook);} ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png'?>"/></a>
					<?php endif; ?>
				</div>
				<div class="profile-link">
					<?php if($model->twitter): ?>
						<a href="<?php if(strpos($model->twitter, 'http')!==false){ echo CHtml::encode($model->twitter);} else {echo 'http://'.CHtml::encode($model->twitter);} ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png'?>"/></a>
					<?php endif; ?>
				</div>
				<div class="profile-link">
					<?php if($model->linkedin): ?>
						<a href="<?php if(strpos($model->linkedin, 'http')!==false){ echo CHtml::encode($model->linkedin);} else {echo 'http://'.CHtml::encode($model->linkedin);} ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png'?>"/></a>
					<?php endif; ?>
				</div>
				<div class="profile-website">
					<?php if($model->website): ?>
						<i class="icon-globe"></i><a class="web-link" href="<?php if(strpos($model->website, 'http')!==false){ echo CHtml::encode($model->website);} else {echo 'http://'.CHtml::encode($model->website);} ?>" target="_blank"><?php echo CHtml::encode($model->website); ?></a>
					<?php endif; ?>
				</div>
			</div>
		
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->company_stage):?>
	<div class="content-wrap" style="position:relative;">

		<div class="content-head">
			<i class="icon-signal profile-icon"></i> Estágio
			<span class="tip">Nível de evolução do nosso Produto</span>
			<!--
			<div style="width:150px; background-color:#bbb; border-radius: 5px; position:absolute; top:10px; right:30px; padding:10px;">
				<?php
			/*
				if($model->company_stage=='Conceito')
				{
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>25, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'danger',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				
				else if($model->company_stage=='Desenvolvimento')
				{
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>50, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'warning',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				
				else if($model->company_stage=='Protótipo')
				{	
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>75, // the progress
						'striped'=>true,
						'animated'=>true,
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				
				else if($model->company_stage=='Produto Final')
				{	
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>100, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'success',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				*/
				?>
				
			</div>
			-->
		</div>
		
		<div class="content-info" style="text-align:center; overflow:visible;">
		
			<?php
			
				if($model->company_stage=='Concept')
				{
					echo "<div style='padding:15px; background:#ccc; border-radius:5px;' data-toggle='tooltip' data-html=true data-original-title='<b>Estágio 1:</b> Conceito'>";
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>25, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'danger',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo "</div>";
					//echo '<br /><b>Stage 1:</b> Conceito';
				}
				
				else if($model->company_stage=='Development')
				{
					echo "<div style='padding:15px; background:#ccc; border-radius:5px;' data-toggle='tooltip' data-html=true data-original-title='<b>Estágio 2:</b> Desenvolvimento'>";
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>50, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'warning',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo "</div>";
					//echo '<br /><b>Stage 2:</b> Desenvolvimento';
				}
				
				else if($model->company_stage=='Prototype')
				{	
					echo "<div style='padding:15px; background:#ccc; border-radius:5px;' data-toggle='tooltip' data-html=true title='<b>Estágio 3:</b> Protótipo'>";
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>75, // the progress
						'striped'=>true,
						'animated'=>true,
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo "</div>";
					//echo '<br /><b>Stage 3:</b> Protótipo';
				}
				
				else if($model->company_stage=='Final Product')
				{	
					echo "<div style='padding:15px; background:#ccc; border-radius:5px;' data-toggle='tooltip' data-html=true data-original-title='<b>Estágio 4:</b> Produto Final'>";
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>100, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'success',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo "</div>";
					//echo '<br /><b>Stage 4:</b> GProduto Final';
				}
			?>
			
		
		</div>
		
	</div>	
	<?php endif;?>
	
	
	<?php if($model->foundation):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-calendar profile-icon"></i> Início da Empresa
			<span class="tip">Data em que a empresa foi criada</span>
		</div>
		
		<div class="content-info">
			
			<?php echo date('d/m/y', strtotime(CHtml::encode($model->foundation))); ?>
			
		</div>
		
	</div>
	<?php endif;?>

	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos AND approved=1', array(':s_id'=>$model->id, ':pos'=>'Founder'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Fundadores</div>
			
			<div class="content-info team-ready">
			
			<?php if(Yii::app()->user->isGuest): ?>
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			<?php else: ?>	
				
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image" style="background-image:url(<?php echo 'http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$usr_startup->profile->logo->name ?>); background-size:cover; background-position: 50% 50%;"></div>
					<div class="team-text">
						<div class="team-name"><span data-id="<?php echo CHtml::encode($usr_startup->id); ?>"><?php echo CHtml::link(CHtml::encode($usr_startup->profile->firstname .' '. $usr_startup->profile->lastname),array('/'.CHtml::encode($usr_startup->username)));?></span></div>
						<div class="team-position"><?php echo CHtml::encode(UserModule::t($rel->position));?></div>
						<div class="team-resume"><?php echo CHtml::encode($usr_startup->profile->resume);?></div>
					</div>
				</div>
				<?php endforeach;?>
			<?php endif;?>															
			</div>
			
		</div>	
	<?php endif;  ?>
	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos AND approved=1', array(':s_id'=>$model->id, ':pos'=>'Member'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Time</div>
			
			<div class="content-info team-ready">
				
			<?php if(Yii::app()->user->isGuest): ?>
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			<?php else: ?>
				
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
					<div class="team-text">
						<div class="team-name"><span data-id="<?php echo CHtml::encode($usr_startup->id); ?>"><?php echo CHtml::link(CHtml::encode($usr_startup->profile->firstname .' '. $usr_startup->profile->lastname),array('/'.CHtml::encode($usr_startup->username)));?></span></div>
						<div class="team-position"><?php echo CHtml::encode(UserModule::t($rel->position));?></div>
						<div class="team-resume"><?php echo CHtml::encode($usr_startup->profile->resume);?></div>
					</div>
				</div>
				<?php endforeach;?>
			
			<?php endif;?>
			</div>
			
		</div>	
	<?php endif;  ?>
	
	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos AND approved=1', array(':s_id'=>$model->id, ':pos'=>'Advisor'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Conselheiros</div>
			
			<div class="content-info team-ready">
				
			<?php if(Yii::app()->user->isGuest): ?>
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			<?php else: ?>
			
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
					<div class="team-text">
						<div class="team-name"><span data-id="<?php echo CHtml::encode($usr_startup->id); ?>"><?php echo CHtml::link(CHtml::encode($usr_startup->profile->firstname .' '. $usr_startup->profile->lastname),array('/'.CHtml::encode($usr_startup->username)));?></span></div>
						<div class="team-position"><?php echo CHtml::encode(UserModule::t($rel->position));?></div>
						<div class="team-resume"><?php echo CHtml::encode($usr_startup->profile->resume);?></div>
					</div>
				</div>
				<?php endforeach;?>
			
			<?php endif;?>
			</div>
			
		</div>	
	<?php endif;  ?>
	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos AND approved=1', array(':s_id'=>$model->id, ':pos'=>'Investor'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Investidores</div>
			
			<div class="content-info team-ready">
				
			<?php if(Yii::app()->user->isGuest): ?>
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			<?php else: ?>
				
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
					<div class="team-text">
						<div class="team-name"><span data-id="<?php echo CHtml::encode($usr_startup->id); ?>"><?php echo CHtml::link(CHtml::encode($usr_startup->profile->firstname .' '. $usr_startup->profile->lastname),array('/'.CHtml::encode($usr_startup->username)));?></span></div>
						<div class="team-position"><?php echo CHtml::encode(UserModule::t($rel->position));?></div>
						<div class="team-resume"><?php echo CHtml::encode($usr_startup->profile->resume);?></div>
					</div>
				</div>
				<?php endforeach;?>
			
			<?php endif;?>
			</div>
			
		</div>	
	<?php endif;  ?>
		

</div>
<!--
	<b><?php echo CHtml::encode($model->getAttributeLabel('one_line_pitch')); ?>:</b>
	<?php echo CHtml::encode($model->one_line_pitch); ?>
	<br />

	
	<b><?php echo CHtml::encode($model->getAttributeLabel('foundation')); ?>:</b>
	<?php echo CHtml::encode($model->foundation); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($model->email); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('telephone')); ?>:</b>
	<?php echo CHtml::encode($model->telephone); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('skype')); ?>:</b>
	<?php echo CHtml::encode($model->skype); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('company_number')); ?>:</b>
	<?php echo CHtml::encode($model->company_number); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('facebook')); ?>:</b>
	<?php echo CHtml::encode($model->facebook); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('twitter')); ?>:</b>
	<?php echo CHtml::encode($model->twitter); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('linkedin')); ?>:</b>
	<?php echo CHtml::encode($model->linkedin); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($model->location); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('client_segment')); ?>:</b>
	<?php echo CHtml::encode($model->client_segment); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('value_proposition')); ?>:</b>
	<?php echo CHtml::encode($model->value_proposition); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('market_size')); ?>:</b>
	<?php echo CHtml::encode($model->market_size); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('sales_marketing')); ?>:</b>
	<?php echo CHtml::encode($model->sales_marketing); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('revenue_generation')); ?>:</b>
	<?php echo CHtml::encode($model->revenue_generation); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('competitors')); ?>:</b>
	<?php echo CHtml::encode($model->competitors); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('competitive_advantage')); ?>:</b>
	<?php echo CHtml::encode($model->competitive_advantage); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('video')); ?>:</b>
	<?php echo CHtml::encode($model->video); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($model->create_time); ?>
	<br />
-->
	 

