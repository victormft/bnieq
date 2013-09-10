<div class="eita">
	
	<?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$data->logo0->name.'" id="Startup-list-img"/>', array('startup/view', 'name'=>$data->name)); ?>
	<?php echo CHtml::link(CHtml::encode($data->name),array('startup/view','name'=>$data->name), array('class'=>'startup-view-name'));?>
	
	<div class="startup-view-pitch">
		<?php echo CHtml::encode($data->one_line_pitch); ?>
	</div>
	
	<div class="startup-view-sec">
		<?php 
		
		echo Startup::model()->findByPk($data->id)->getSectorNames();
		
		//echo $data->getSectorNames(); 
		
		?>
	</div>
	
</div>