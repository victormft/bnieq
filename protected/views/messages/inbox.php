<?php $this->pageTitle=Yii::app()->name . ' - '.MessageModule::t("Messages:inbox"); ?>


<div class="row">
    <?php $this->renderPartial('_navigation', array('active'=>'inbox')); ?>
    
    <div class="messages-wrap">
        <div class="span8">
            <h2><?php echo MessageModule::t('Inbox'); ?></h2>

            <?php if ($messagesAdapter->data): ?>

                <?php $this->widget('bootstrap.widgets.TbGridView', array(
                    'id'=>'message-grid',
                    'type' => 'striped bordered condensed',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'columns'=>array(
                        array(
                            'name' => 'sender_name',
                            'type'=>'raw',
                            'value' => '$data->getSenderName()',
                        ),
                        array(
                            'name' => 'subject',
                            'type'=>'raw',
                            'value' => 'CHtml::link(CHtml::encode($data->subject),array("messages/view","message_id"=>$data->id))',
                        ),
                        array(
                            'name' => 'created_at',
                            'type'=>'raw',
                            'value' => 'date("d/m/Y h:i", strtotime($data->created_at))',
                        ),
                        array(
                            'htmlOptions' => array('nowrap'=>'nowrap'),
                            'class'=>'bootstrap.widgets.TbButtonColumn',
                            'viewButtonUrl'=>'Yii::app()->createUrl("/messages/view", array("message_id"=>$data->id))',
                            //'updateButtonUrl'=>'Yii::app()->createUrl("/user/admin/updatestartup", array("id"=>$data->id))',
                            //'deleteButtonUrl'=>'Yii::app()->createUrl("/user/admin/deletestartup", array("id"=>$data->id))',
                        )
                    ),
                )); ?>
            
            <?php endif; ?>
        </div>
    </div>
</div>
