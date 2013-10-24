
<div class="view-pitch-list">

	<?php /*<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />*/ ?>

	<?php /*<b><?php echo CHtml::encode($data->getAttributeLabel('startup_id')); ?>:</b>*/ ?>
	
	<b><?php 
	$startup = Startup::model()->findByPk($data->startup_id);
	
	echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$startup->logo0->name.'" id="Startup-list-img"/>', array('startup/view', 'name'=>$startup->name)); 
	?></b>
	<br />
	<?php 
	echo CHtml::link(CHtml::encode($startup->name),array('startup/view','name'=>$startup->name) );
	?>
	<br />
	
	<div>
	
	<?php echo CHtml::encode($data->pitch_text); ?>
	
	</div>
	<br />
	
	
	<b><?php echo 'Meta de investimento: ' ?></b>
	
	<?php echo 'R$ '. CHtml::encode($data->investment_required); ?>
	<br />
	
	<b><?php echo 'Meta alcançada: ' ?></b>
	
	<?php echo 'R$ '. CHtml::encode($data->funded); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equity')); ?>:</b>
	<?php echo CHtml::encode($data->equity); ?>
	<?php echo '%';?>
	<br />

	

	
	<!--<b><?php /* echo CHtml::encode($data->getAttributeLabel('video')); ?>:</b>
	<?php echo CHtml::encode($data->video); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('exit_strategy')); ?>:</b>
	<?php echo CHtml::encode($data->exit_strategy); */ ?>
	<br /> -->
	
	<div style="background: rgb(200,200,200);  width: 500px; height: 12px; border-radius: 5px 5px 5px 5px;">
		<div style="background: rgb(255,180, 0);  width: 
		<?php echo (($data->funded/$data->investment_required)  * 500) . 'px;'; ?> height: 12px; border-radius: 5px 5px 5px 5px;">
		
	</div>
	</div>
	<br/ >
	<br>
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />
	

	*/ ?>

</div>
<div style="height: 20px;">

</div>