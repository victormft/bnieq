
<div class="view-pitch-list">

	<?php /*<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />*/ ?>

	<?php /*<b><?php echo CHtml::encode($data->getAttributeLabel('startup_id')); ?>:</b>*/ ?>
	
	<?php 
	$startup = Startup::model()->findByPk($data->startup_id);
	
	echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$startup->logo0->name.'" id="Startup-list-img"/>', array('startup/view', 'name'=>$startup->name)); 
	?>
	<br />
	<b>
	<?php 
	echo CHtml::link(CHtml::encode($startup->name),array('startup/view','name'=>$startup->startupname) );
	?>
	</b>
	<br />
	
	<div>
	<p>
	<?php echo substr($data->pitch_text ,0,150) . '...' . CHtml::link('Continuar Lendo',array('pitch/view','id'=>$data->id) ); ?>
	
	</div>
	<br />
	
	<div>
	<b><span style="color: rgb(150, 150, 150);"><?php echo 'Meta: ' ?></b>
	
	<?php echo 'R$ '. CHtml::encode($data->investment_required); ?></span>
	<br />
	
	<b><span style="color: rgb(150, 150, 150);"><?php echo 'Alcançado: ' ?></b>
	
	<?php echo 'R$ '. CHtml::encode($data->funded); ?></span>
	<br />

	<b><span style="color: rgb(150, 150, 150);"><?php echo CHtml::encode($data->getAttributeLabel('equity')); ?>:</b></span>
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
		<div style="background: rgb(50,150, 244);  width: 
		<?php $bar_size = ($data->funded/$data->investment_required)  * 500;
		if($bar_size > 500)
			{$bar_size = 500;}
		echo $bar_size . 'px;'; 
		?> height: 12px; border-radius: 5px 5px 5px 5px;">
	</div>
	</div>
	</div>
	<br/ >
	<br>
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />
	

	*/ ?>
</p>
</div>
<div style="height: 20px;">

</div>