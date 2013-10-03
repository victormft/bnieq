<?php $this->pageTitle=Yii::app()->name . ' - ' . MessageModule::t("Compose Message"); ?>
<?php $isIncomeMessage = $viewedMessage->receiver_id == Yii::app()->user->getId() ?>

<?php
	$this->breadcrumbs = array(
		MessageModule::t("Messages"),
		($isIncomeMessage ? MessageModule::t("Inbox") : MessageModule::t("Sent")) => ($isIncomeMessage ? 'inbox' : 'sent'),
		CHtml::encode($viewedMessage->subject),
	);
?>

<div class="row">
<?php $this->widget('bootstrap.widgets.TbMenu', array(
        'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>true, // whether this is a stacked menu
        'htmlOptions'=>array('style'=>'width:20%; float:left; margin-right:20px'),
        'items'=>array(
            array('label'=>'Inbox', 'url'=>'inbox'),
            array('label'=>'Sent', 'url'=>'sent'),
            array('label'=>'Compose', 'url'=>'compose'),
        ),
    )); ?>
    
    <?php $this->renderPartial('_navigation') ?>
    
	<div class="span8">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'message-delete-form',
			'enableAjaxValidation'=>false,
			'action' => $this->createUrl('messages/delete/', array('id' => $viewedMessage->id))
		)); ?>
		<button class="btn danger"><?php echo MessageModule::t("Delete") ?></button>
		<?php $this->endWidget(); ?>

		<table class="bordered-table zebra-striped">
			<tr>
				<th>
					<?php if ($isIncomeMessage): ?>
						From: <?php echo $viewedMessage->getSenderName() ?>
					<?php else: ?>
						To: <?php echo $viewedMessage->getReceiverName() ?>
					<?php endif; ?>
				</th>
				<th>
					<?php echo CHtml::encode($viewedMessage->subject) ?>
				</th>
				<th>
					<?php echo date('d-m-Y H:i:s', strtotime($viewedMessage->created_at)) ?>
				</th>
			</tr>
			<tr>
				<td colspan="3">
					<?php echo CHtml::encode($viewedMessage->body) ?>
				</td>
			</tr>
		</table>

		<h2><?php echo MessageModule::t('Reply') ?></h2>

		<div class="form">
			<?php $form = $this->beginWidget('CActiveForm', array(
				'id'=>'message-form',
				'enableAjaxValidation'=>false,
			)); ?>

			<?php echo $form->errorSummary($message, null, null, array('class' => 'alert-message block-message error')); ?>

			<div class="input">
				<?php echo $form->hiddenField($message,'receiver_id'); ?>
				<?php echo $form->error($message,'receiver_id'); ?>
			</div>
			<?php echo $form->labelEx($message,'subject'); ?>
			<div class="input">

				<?php echo $form->textField($message,'subject'); ?>
				<?php echo $form->error($message,'subject'); ?>
			</div>

			<?php echo $form->labelEx($message,'body'); ?>
			<div class="input">
				<?php echo $form->textArea($message,'body'); ?>
				<?php echo $form->error($message,'body'); ?>
			</div>

			<div class="buttons">
				<button class="btn primary"><?php echo MessageModule::t("Reply") ?></button>
			</div>

			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>