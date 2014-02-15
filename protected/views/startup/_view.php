<div class="view-list">
	
	<?php echo CHtml::link('<div class="startup-view-img" style="background-image:url(http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$data->logo0->name.'); background-size:cover; background-position: 50% 50%;"></div>', array('/'.CHtml::encode($data->startupname)));?>
	
	<div class="view-list-text" style="overflow:hidden; max-width:280px;">
		
		<?php echo CHtml::link(CHtml::encode($data->name),array('/'.CHtml::encode($data->startupname)), array('class'=>'startup-view-name'));?>
		
		<div class="startup-view-pitch">
			<?php echo CHtml::encode($data->one_line_pitch); ?>
		</div>

		<div class="startup-view-sect">
		<!--<div class="startup-view-sec">!!!!soh pra fechar-></div>-->
			<?php 
			
			echo Startup::model()->findByPk($data->id)->getSectorForPrint();
			
			//echo $data->getSectorNames(); 
			
			?>
		</div>
		
		<div class="startup-view-location">
			<i class="icon-map-marker"></i><?php if (isset($data->city)): ?><a href="<?php echo Yii::app()->baseUrl.'/startup?g=&c='.CHtml::encode($data->city->id); ?>"><?php echo CHtml::encode($data->city->nome); ?></a> <?php endif; ?>		
		</div>
	
	</div>
	
		<div class="joined-date"><?php echo date('d/m/y', strtotime(CHtml::encode($data->create_time))); ?></div> 
		<div class="follow-count" data-name="<?php echo CHtml::encode($data->startupname); ?>"><?php echo count($data->users); ?></div>   
	
	<?php if(!Yii::App()->user->isGuest): ?>	
		<span class="follow-btn">    
			<?php 
			if(!$data->hasUserFollowing(Yii::app()->user->id))
			{
				$this->widget('bootstrap.widgets.TbButton', array(
				'label'=>UserModule::t('Follow'),
				'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'mini', // null, 'large', 'small' or 'mini'
				'url'=>'',//array('follow','name'=>$model->name),
				'htmlOptions'=>array('class'=>'btn-follow follow-press',),
				)); 
			}
			else
			{
				$this->widget('bootstrap.widgets.TbButton', array(
				'label'=>UserModule::t('Unfollow'),
				'size'=>'mini', // null, 'large', 'small' or 'mini'
				'url'=>'',//array('unfollow','name'=>$model->name),
				'htmlOptions'=>array('class'=>'btn-unfollow follow-press'),
				)); 
			}
			?>        
		</span>
	<?php endif;?>
	
	
	<!--Followers: <?php //echo count($data->users); ?>-->
	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('foundation')); ?>:</b>
	<?php echo CHtml::encode($data->foundation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telephone')); ?>:</b>
	<?php echo CHtml::encode($data->telephone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('skype')); ?>:</b>
	<?php echo CHtml::encode($data->skype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('company_number')); ?>:</b>
	<?php echo CHtml::encode($data->company_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('facebook')); ?>:</b>
	<?php echo CHtml::encode($data->facebook); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('twitter')); ?>:</b>
	<?php echo CHtml::encode($data->twitter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('blog')); ?>:</b>
	<?php echo CHtml::encode($data->blog); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_segment')); ?>:</b>
	<?php echo CHtml::encode($data->client_segment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('value_proposition')); ?>:</b>
	<?php echo CHtml::encode($data->value_proposition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('market_size')); ?>:</b>
	<?php echo CHtml::encode($data->market_size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_marketing')); ?>:</b>
	<?php echo CHtml::encode($data->sales_marketing); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('revenue_generation')); ?>:</b>
	<?php echo CHtml::encode($data->revenue_generation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('competitors')); ?>:</b>
	<?php echo CHtml::encode($data->competitors); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('competitive_advantage')); ?>:</b>
	<?php echo CHtml::encode($data->competitive_advantage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('video')); ?>:</b>
	<?php echo CHtml::encode($data->video); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	*/ ?>

</div>