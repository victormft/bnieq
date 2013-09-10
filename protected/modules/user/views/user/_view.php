<div class="view-list">

	<?php echo CHtml::link(CHtml::encode($data->firstname),array('/user/profile','id'=>$data->user_id), array('class'=>'startup-view-name'));?>
	

	
	<div class="startup-view-pitch">
		<?php //echo CHtml::encode($data->one_line_pitch); ?>
	</div>

	
	<div class="startup-view-sec">
		<?php 
		
		//echo Startup::model()->findByPk($data->id)->getSectorNames();
		
		//echo $data->getSectorNames(); 
		
		?>
	</div>

</div>