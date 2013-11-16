<div class="spacing-1"></div>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
        'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
        'id'=>'messages-menu',
        'stacked'=>true, // whether this is a stacked menu
        'items'=>array(
            array('label'=>UserModule::t('Inbox'), 'url'=>'inbox', 'active'=>($active==='inbox') ? true:false),
            array('label'=>UserModule::t('Sent'), 'url'=>'sent', 'active'=>($active==='sent') ? true:false),
        ),
    )); ?>

<?php $this->renderPartial('_newboots') ?>

<?php if(Yii::app()->user->hasFlash('messageModule')): ?>
	<div class="success">
		<?php echo Yii::app()->user->getFlash('messageModule'); ?>
	</div>
<?php endif; ?>



