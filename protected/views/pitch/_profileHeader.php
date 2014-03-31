
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
			<li class="chooser info <?php if ($param == 'detail') echo 'clicked'; ?>" id="pitch-ajax-detail">
				<!--<a href="javascript:void(0)"><?php echo /*UserModule::t('Informations')*/'Detalhes';?></a> -->
                            <?php echo CHtml::link('Detalhes',array('pitch/index',
                                         'name'=>$startup_model->name)); ?>
			</li>
			<li class="chooser activity <?php if ($param == 'qa') echo 'clicked'; ?>" id="thread-ajax-index">
				<!--<a href="javascript:void(0)"><?php echo /*UserModule::t('Activities')*/'Q&A';?></a> -->
                            <?php echo CHtml::link('Q&A',array('thread/index',
                                         'startupId'=>$startup_model->id)); ?>
			</li>
			<li class="chooser press">
				<a href="javascript:void(0)"><?php echo UserModule::t('Press');?></a>
			</li>
	</div>
</div>


