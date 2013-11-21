
<?php $startup_model = Startup::model()->findByPk($model->startup_id);?>



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
			<i class="icon-map-marker profile-icon"></i><?php if (isset($startup_model->city)) echo $startup_model->city->nome; ?>
		</div>
		
		
		<div class="profile-location">
			<i class="icon-circle-blank profile-icon"></i><span><?php echo 'Equity: ' . $model->equity . '%'; ?></span>
		</div>
		<div class="profile-location">
			<i class="icon-circle-blank profile-icon"></i><span><?php echo 'Meta: R$' . $model->investment_required; ?></span>
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
				'url'=>array('edit','name'=>$startup_model->startupname),
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
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i>Sobre nós</span>
			<span class="tip">Entenda nosso conceito</span>
		</div>
		
		<div class="content-info">
			<?php echo $model->pitch_text?> 		
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-picture profile-icon-vid"></i>Video
			<span class="tip">Video sobre o pitch</span>
		</div>
		
		<div class="content-info video-images">
			<div class="video-images-items">
				<?php if($model->video){$this->widget('ext.Yiitube', array('size' => 'small', 'v' => $model->video));} ?>
			</div>
			<div class="pagination carousel-pag" id="video-images-pagination"></div>
		</div>
		
	</div>	
	
	
	<?php if($startup_model->history):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-book profile-icon"></i> História da Empresa
			<span class="tip">ddad as d sd a d</span>
		</div>
		
		<div class="content-info">
			
			<?php echo $startup_model->history;?> 
			
		</div>
		
	</div>
	<?php endif;?>
	
	

</div>

<div class="profile-column-r">
	
	<?php if($startup_model->facebook || $startup_model->twitter || $startup_model->linkedin || $startup_model->website):?>
	<div class="content-wrap">

		<div class="content-head rounded social-web">
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
					<i class="icon-globe"></i><a class="web-link" href="<?php echo $startup_model->website; ?>" target="_blank"><?php echo $startup_model->website; ?></a>
				</div>
			</div>
		
		</div>
		
	</div>	
	<?php endif;?>
	
	
	<div class="content-wrap" style="position:relative;">

		<div class="content-head">
			<i class="icon-money profile-icon"></i> Investimento
			<span class="tip">Quanto foi investido até agora</span>
			<!--
			<div style="width:150px; background-color:#bbb; border-radius: 5px; position:absolute; top:10px; right:30px; padding:10px;">
				<?php
			/*
				if($startup_model->company_stage=='Conceito')
				{
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>25, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'danger',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				
				else if($startup_model->company_stage=='Desenvolvimento')
				{
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>50, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'warning',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				
				else if($startup_model->company_stage=='Protótipo')
				{	
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>75, // the progress
						'striped'=>true,
						'animated'=>true,
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				
				else if($startup_model->company_stage=='Produto Final')
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
			
			<div><span class="pitch-funded-value">R$<?php echo $model->funded; ?></span></div><b> investidos da nossa meta de <span style="color: rgb(150,80,30);">R$<?php echo $model->investment_required;?></b></span>
			<?php
			
					echo "<div style='padding:15px; background:#ccc; border-radius:5px;' data-toggle='tooltip' data-html=true>";
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>($model->funded/$model->investment_required * 100), // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'success',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo "</div>";
			?>
			
		
		</div>
		
	</div>
	<div class="content-wrap">

		<div class="content-head"><i class="icon-group profile-icon"></i> Fundadores</div>
		
		<div class="content-info team-ready">
			
			
			<?php foreach($startup_model->users1 as $usr_startup):  ?>
			<?php $relational_tbl=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$usr_startup->id, ':s_id'=>$startup_model->id)); ?>
			<?php if($relational_tbl->position=='Founder'):?>
			<div class="team-item">		
				<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
				<div class="team-name"><span data-id="<?php echo $usr_startup->id; ?>"><?php echo $usr_startup->profile->firstname . ' ' . $usr_startup->profile->lastname; ?></span></div>
				<div class="team-position"><?php echo $relational_tbl->position;?></div>
				<div class="team-resume"><?php echo $usr_startup->profile->resume;?></div>
			</div>
			<?php endif;  ?>
			<?php endforeach;  ?>
			
				
			
			
		
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head">
			<span class="txt"><i class="icon-exclamation profile-icon"></i>Estratégia de Saída</span>
			<span class="tip">Estratégia de Saída</span>
		</div>
		
		<div class="content-info">
			<?php echo $model->exit_strategy?> 		
		</div>
		
	</div>	
	
	
	

</div>
<!--
	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('one_line_pitch')); ?>:</b>
	<?php echo CHtml::encode($startup_model->one_line_pitch); ?>
	<br />

	
	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('foundation')); ?>:</b>
	<?php echo CHtml::encode($startup_model->foundation); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($startup_model->email); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('telephone')); ?>:</b>
	<?php echo CHtml::encode($startup_model->telephone); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('skype')); ?>:</b>
	<?php echo CHtml::encode($startup_model->skype); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('company_number')); ?>:</b>
	<?php echo CHtml::encode($startup_model->company_number); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('facebook')); ?>:</b>
	<?php echo CHtml::encode($startup_model->facebook); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('twitter')); ?>:</b>
	<?php echo CHtml::encode($startup_model->twitter); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('linkedin')); ?>:</b>
	<?php echo CHtml::encode($startup_model->linkedin); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($startup_model->location); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('client_segment')); ?>:</b>
	<?php echo CHtml::encode($startup_model->client_segment); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('value_proposition')); ?>:</b>
	<?php echo CHtml::encode($startup_model->value_proposition); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('market_size')); ?>:</b>
	<?php echo CHtml::encode($startup_model->market_size); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('sales_marketing')); ?>:</b>
	<?php echo CHtml::encode($startup_model->sales_marketing); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('revenue_generation')); ?>:</b>
	<?php echo CHtml::encode($startup_model->revenue_generation); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('competitors')); ?>:</b>
	<?php echo CHtml::encode($startup_model->competitors); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('competitive_advantage')); ?>:</b>
	<?php echo CHtml::encode($startup_model->competitive_advantage); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('video')); ?>:</b>
	<?php echo CHtml::encode($startup_model->video); ?>
	<br />

	<b><?php echo CHtml::encode($startup_model->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($startup_model->create_time); ?>
	<br />
-->
	 

