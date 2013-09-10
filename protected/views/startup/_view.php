<div class="view-list">

		
	

	<?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$data->logo0->name.'" id="Startup-list-img"/>', array('view', 'name'=>$data->name)); ?>
	

	<?php echo CHtml::link(CHtml::encode($data->name),array('view','name'=>$data->name), array('class'=>'startup-view-name'));?>
	

	<!--<b><?php /*echo CHtml::encode($data->getAttributeLabel('one_line_pitch')); */?>:</b>-->
	
	<div class="startup-view-pitch">
		<?php echo CHtml::encode($data->one_line_pitch); ?>
	</div>

	
	<div class="startup-view-sec">
		<?php 
		
		echo Startup::model()->findByPk($data->id)->getSectorNames();
		
		//echo $data->getSectorNames(); 
		
		?>
	</div>
	
	Followers: <?php echo count($data->users); ?>
	
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