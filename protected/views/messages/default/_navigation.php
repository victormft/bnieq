<?php $this->renderPartial('_styles') ?>

<ul class="actions">
	<li><a href="<?php echo $this->createUrl('messages/inbox/') ?>">inbox
		<?php if (Message::model()->getCountUnreaded(Yii::app()->user->getId())): ?>
			(<?php echo Message::model()->getCountUnreaded(Yii::app()->user->getId()); ?>)
		<?php endif; ?>
	</a></li>
	<li><a href="<?php echo $this->createUrl('messages/sent/sent') ?>">sent</a></li>
	<li><a href="<?php echo $this->createUrl('messages/compose/') ?>">compose</a></li>
</ul>

<?php if(Yii::app()->user->hasFlash('messageModule')): ?>
	<div class="success">
		<?php echo Yii::app()->user->getFlash('messageModule'); ?>
	</div>
<?php endif; ?>
