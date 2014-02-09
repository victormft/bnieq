<?php
/* @var $this ThreadController */
/* @var $data Thread */
?>


<div class="thread-row">
        <div class="thread-cell">
            <p><?php echo CHtml::link(CHtml::encode($data->title),array('thread/view','id'=>$data->id), array('id' => 'thread-ajax-view'));?></p>
			
        
		
		</div>
        <div class="thread-cell">
            <p><?php $user_model =User::model()->findByPk($data->user_id);
				echo $user_model->username;
				?></p>
        </div>
        <div class="thread-cell">
            <p><?php echo $data->replies; ?></p>
        </div>
		<div class="thread-cell">
            <p><?php echo $data->views; ?></p>
        </div>
		<div class="thread-cell">
            <p><?php echo $data->last_post; ?></p>
			<p><?php 
				$last_post_user_model = User::model()->findByPk($data->last_post_user_id);
				echo 'by:'.$last_post_user_model->username; ?> 
			</p>
        </div>
   </div>
	<!--<b><?php //echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php //echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php //echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('replies')); ?>:</b>
	<?php //echo CHtml::encode($data->replies); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('views')); ?>:</b>
	<?php //echo CHtml::encode($data->views); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('last_post')); ?>:</b>
	<?php //echo CHtml::encode($data->last_post); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php //echo CHtml::encode($data->title); ?>
	<br />

	<b><?php //echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php //echo CHtml::encode($data->create_time); ?>
	<br /> -->
