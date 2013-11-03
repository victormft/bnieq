<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Messages:sent"); ?>



<div class="row">
    <?php $this->renderPartial('_navigation', array('active'=>'sent')); ?>
    
    <div class="messages-wrap">
        <div class="span8">
        <h2><?php echo UserModule::t('Sent'); ?></h2>

                <?php $this->widget('bootstrap.widgets.TbGridView', array(
                    'id'=>'message-grid',
                    'type' => 'striped bordered condensed',
                    'dataProvider'=>$model->searchForSent(),
                    'filter'=>$model,
                    'columns'=>array(
                        array(
                            'name' => 'receiver_name',
                            'type'=>'raw',
                            'value' => '$data->getReceiverName()',
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
                            'htmlOptions' => array('style'=>'text-align: center;'),
                            'class'=>'bootstrap.widgets.TbButtonColumn',
                            'template' => '{view}{delete}',
                            'viewButtonUrl'=>'Yii::app()->createUrl("/messages/view", array("message_id"=>$data->id))',
                            //'updateButtonUrl'=>'Yii::app()->createUrl("/user/admin/updatestartup", array("id"=>$data->id))',
                            //'deleteButtonUrl'=>'Yii::app()->createUrl("/user/admin/deletestartup", array("id"=>$data->id))',
                        )
                    ),
                )); ?>

        </div>
    </div>
</div>
