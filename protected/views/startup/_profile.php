<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.carouFredSel-6.2.1.js');

Yii::app()->clientScript->registerScript('follow',
"


$('#follow').click(function(event) {


		if($('#follow').text()=='Follow')
		{	
			$('#follow').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/follow?name='+getUrlVars()['name'],
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
				url: '".Yii::app()->request->baseUrl."/startup/unfollow?name='+getUrlVars()['name'],
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
	<div id="startup-profile-img">
		<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$model->logo0->name ?>"/>
	</div>
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
					<div class="follow-count"><?php echo count($model->users); ?></div><div class="follow-status">Followers</div>
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
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i>O Produto</span>
			<span class="tip">Entenda qual a solução proposta pela nossa Empresa</span>
		</div>
		
		<div class="content-info">
			<?php echo $model->product_description;?> 		
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
				<?php if($model->video){$this->widget('ext.Yiitube', array('size' => 'small', 'v' => $model->video));} ?>	
				<?php foreach($model->images as $img) :?>
					<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$img->name ?>" id="generic-img" alt="asdasd" style="float:left; width: 500px; height:312px;"/>
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
			
			<?php echo $model->tech;?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->client_segment):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-screenshot profile-icon"></i> Público Alvo
			<span class="tip">ddad as d sd a d</span>
		</div>
		
		<div class="content-info">
			
			<?php echo $model->client_segment;?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->revenue_generation):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-money profile-icon"></i> Geração de Renda
			<span class="tip">ddad as d sd a d</span>
		</div>
		
		<div class="content-info">
			
			<?php echo $model->revenue_generation;?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->competitors):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-warning-sign profile-icon"></i> Principais Concorrentes
			<span class="tip">ddad as d sd a d</span>
		</div>
		
		<div class="content-info">
			
			<?php echo $model->competitors;?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->competitive_advantage):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-trophy profile-icon"></i> Vantagem Competitiva
			<span class="tip">ddad as d sd a d</span>
		</div>
		
		<div class="content-info">
			
			<?php echo $model->competitive_advantage;?> 
			
		</div>
		
	</div>	
	<?php endif;?>
	
	<?php if($model->history):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-book profile-icon"></i> História da Empresa
			<span class="tip">ddad as d sd a d</span>
		</div>
		
		<div class="content-info">
			
			<?php echo $model->history;?> 
			
		</div>
		
	</div>
	<?php endif;?>
	
	

</div>

<div class="profile-column-r">
	
	<?php if($model->facebook || $model->twitter || $model->linkedin || $model->website):?>
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
		
		<div class="content-info" style="text-align:center;">
		
			<?php
			
				if($model->company_stage=='Conceito')
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
				
				else if($model->company_stage=='Desenvolvimento')
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
				
				else if($model->company_stage=='Protótipo')
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
				
				else if($model->company_stage=='Produto Final')
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

	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos', array(':s_id'=>$model->id, ':pos'=>'Founder'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Fundadores</div>
			
			<div class="content-info team-ready">
				
				
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
					<div class="team-name"><span data-id="<?php echo $usr_startup->id; ?>"><?php echo $usr_startup->profile->firstname . ' ' . $usr_startup->profile->lastname; ?></span></div>
					<div class="team-position"><?php echo $rel->position;?></div>
					<div class="team-resume"><?php echo $usr_startup->profile->resume;?></div>
				</div>
				<?php endforeach;?>
																		
			</div>
			
		</div>	
	<?php endif;  ?>
	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos', array(':s_id'=>$model->id, ':pos'=>'Member'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Time</div>
			
			<div class="content-info team-ready">
				
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
					<div class="team-name"><span data-id="<?php echo $usr_startup->id; ?>"><?php echo $usr_startup->profile->firstname . ' ' . $usr_startup->profile->lastname; ?></span></div>
					<div class="team-position"><?php echo $rel->position;?></div>
					<div class="team-resume"><?php echo $usr_startup->profile->resume;?></div>
				</div>
				<?php endforeach;?>
			
			</div>
			
		</div>	
	<?php endif;  ?>
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-group profile-icon"></i> Conselheiros</div>
		
		<div class="content-info">
			
			COMING SOON!!
		
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
	 

