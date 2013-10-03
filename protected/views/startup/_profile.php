<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.carouFredSel-6.2.1.js');

Yii::app()->clientScript->registerScript('follow',
"


$('#yw1').click(function(event) {


		if($('#yw1').text()=='Follow')
		{	
			$('#yw1').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/follow?name='+getUrlVars()['name'],
				dataType: 'json',
				success: function(data){
					$('#yw1').removeClass('btn-success');
					$('#yw1').text('Unfollow');	
					$('.follow-count').html(data.res);
				}
			});
		}
		
		else if($('#yw1').text()=='Unfollow')
		{
			$('#yw1').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/unfollow?name='+getUrlVars()['name'],
				dataType: 'json',
				success: function(data){
					$('#yw1').addClass('btn-success');
					$('#yw1').text('Follow');
					$('.follow-count').html(data.res);					
				}
			});
		}
			
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
		items : 1,
		auto:false,
		pagination: '#video-images-pagination'
	});	




");

?>


<div class="profile-header">	

	<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$model->logo0->name ?>" id="startup-profile-img" />
	
	<div class="profile-header-info">
		
		<div class="profile-name">
			<span><?php echo $model->name; ?></span>
		</div>
		
		<div class="profile-onelinepitch">
			<span style="font-style:italic;"><?php echo $model->one_line_pitch; ?></span>
		</div>
		
		<div class="profile-sectors">
			<span><?php echo $model->getSectorNames(); ?></span>
		</div>
		
		<div class="profile-location">
			<i class="icon-map-marker profile-icon"></i><?php if (isset($model->city)) echo $model->city->nome; ?>
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
		
			<span class="edit-btn">
			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Editar',
				'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'normal', // null, 'large', 'small' or 'mini'
				'url'=>array('edit','name'=>$model->name),
				'htmlOptions'=>array('style'=>'text-shadow: 1px 1px 1px #555;', /*'class'=>'profile-btn'*/),
					)); 
				?>
			</span>
			
			<span class="follow-btn">
			
			
				<div class="follow-info">
					<div class="follow-count"><?php echo count($model->users); ?></div><div class="follow-status">Followers</div>
				</div>

				<?php 
					
					if(!$model->hasUserFollowing(Yii::app()->user->id))
					{
						$this->widget('bootstrap.widgets.TbButton', array(
						'label'=>'Follow',
						'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						'size'=>'normal', // null, 'large', 'small' or 'mini'
						'url'=>'',//array('follow','name'=>$model->name),
						'htmlOptions'=>array('style'=>'width:50px; padding-top:8px; padding-bottom:8px; font-weight:bold; text-shadow: 1px 1px 1px #555; margin-top:5px;'),
						)); 
					}
					
					else
					{
						$this->widget('bootstrap.widgets.TbButton', array(
						'label'=>'Unfollow',
						'size'=>'normal', // null, 'large', 'small' or 'mini'
						'url'=>'',//array('unfollow','name'=>$model->name),
						'htmlOptions'=>array('style'=>'width:50px; padding-top:12px; padding-bottom:12px;'),
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
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head"><span class="txt"><i class="icon-lightbulb profile-icon"></i>O Produto</span></div>
		
		<div class="content-info">
			<?php echo $model->product_description;?> 
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-picture profile-icon-vid"></i>Video & Imagens</div>
		
		<div class="content-info video-images">
			<div class="video-images-items">
				<?php $this->widget('ext.Yiitube', array('size' => 'small', 'v' => $model->video)); ?>	
				<?php foreach($model->images as $img) :?>
					<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$img->name ?>" id="generic-img" alt="asdasd" style="float:left; width: 500px; height:312px;"/>
				<?php endforeach; ?>
			</div>
			<div class="pagination carousel-pag" id="video-images-pagination"></div>
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-cogs profile-icon"></i> Tecnologia</div>
		
		<div class="content-info">
			
			<?php echo $model->tech;?> 
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-group profile-icon"></i> Público Alvo </div>
		
		<div class="content-info">
			
			<?php echo $model->client_segment;?> 
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-money profile-icon"></i> Geração de Renda</div>
		
		<div class="content-info">
			
			<?php echo $model->revenue_generation;?> 
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-warning-sign profile-icon"></i> Principais Concorrentes</div>
		
		<div class="content-info">
			
			<?php echo $model->competitors;?> 
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-trophy profile-icon"></i> Vantagem Competitiva</div>
		
		<div class="content-info">
			
			<?php echo $model->competitive_advantage;?> 
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-book profile-icon"></i> História da Empresa</div>
		
		<div class="content-info">
			
			<?php echo $model->product_description;?> 
			
		</div>
		
	</div>	
	
	

</div>

<div class="profile-column-r">

	<div class="content-wrap">

		<div class="content-head rounded social-web">
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
					<i class="icon-globe"></i><a class="web-link" href="<?php echo $model->website; ?>" target="_blank"><?php echo $model->website; ?></a>
				</div>
			</div>
		
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-link profile-icon"></i> Website</div>
		
		<div class="content-info">
			
			<?php echo 'website'; ?>
		
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-road profile-icon"></i> Company Stage</div>
		
		<div class="content-info" style="text-align:center;">
			
			<?php
			
				if($model->company_stage=='Conceito')
				{
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>25, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'danger',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo '<br /><b>Stage 1:</b> Conceito';
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
					echo '<br /><b>Stage 2:</b> Desenvolvimento';
				}
				
				else if($model->company_stage=='Protótipo')
				{	
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>75, // the progress
						'striped'=>true,
						'animated'=>true,
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo '<br /><b>Stage 3:</b> Protótipo';
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
					echo '<br /><b>Stage 4:</b> GProduto Final';
				}
			?>
		
		</div>
		
	</div>	

	<div class="content-wrap">

		<div class="content-head"><i class="icon-link profile-icon"></i> Fundadores</div>
		
		<div class="content-info">
			
			<?php echo 'website'; ?>
		
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-link profile-icon"></i> Time</div>
		
		<div class="content-info">
			
			<?php echo 'website'; ?>
		
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-link profile-icon"></i> Conselheiros</div>
		
		<div class="content-info">
			
			<?php echo 'website'; ?>
		
		</div>
		
	</div>	
	

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
	 

