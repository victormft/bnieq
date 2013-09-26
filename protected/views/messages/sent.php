<?php $this->pageTitle=Yii::app()->name . ' - '.MessageModule::t("Messages:sent"); ?>
<?php
	$this->breadcrumbs=array(
		MessageModule::t("Messages"),
		MessageModule::t("Sent"),
	);
?>


<div class="row">
<?php $this->widget('bootstrap.widgets.TbMenu', array(
        'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>true, // whether this is a stacked menu
        'htmlOptions'=>array('style'=>'width:20%; float:left; margin-right:20px'),
        'items'=>array(
            array('label'=>'Inbox', 'url'=>'inbox'),
            array('label'=>'Sent', 'url'=>'sent', 'active'=>true),
            array('label'=>'Compose', 'url'=>'compose'),
        ),
    )); ?>
    
	<?php $this->renderPartial('_navigation') ?>
    
	<div class="span8">
	<h2><?php echo MessageModule::t('Sent'); ?></h2>

		<?php if ($messagesAdapter->data): ?>
			<?php $form = $this->beginWidget('CActiveForm', array(
				'id'=>'message-delete-form',
				'enableAjaxValidation'=>false,
				'action' => $this->createUrl('messages/delete/')
			)); ?>

			<table class="bordered-table zebra-striped">
				<tr>
					<th  class="from-to">To</th>
					<th>Subject</th>
					<th>Date</th>
				</tr>
				<?php foreach ($messagesAdapter->data as $index => $message): ?>
					<tr>
						<td>
							<?php echo CHtml::checkBox("Message[$index][selected]"); ?>
							<?php echo $form->hiddenField($message,"[$index]id"); ?>
							<?php echo $message->getReceiverName() ?>
						</td>
						<td><a href="<?php echo $this->createUrl('messages/view/', array('message_id' => $message->id)) ?>"><?php echo $message->subject ?></a></td>
						<td><span class="date"><?php echo date('d-m-Y H:i:s', strtotime($message->created_at)) ?></span></td>
					</tr>
				<?php endforeach ?>
			</table>

			<div>
				<button class="btn danger"><?php echo MessageModule::t("Delete Selected") ?></button>
			</div>

			<?php $this->endWidget(); ?>

			<div class="pagination">
				<?php $this->widget('CLinkPager', array('header' => '', 'pages' => $messagesAdapter->getPagination(), 'htmlOptions' => array('class' => 'pager'))) ?>
			</div>
		<?php endif; ?>
	</div>
</div>
