<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Messages:inbox"); ?>


<div class="row">
    <?php $this->renderPartial('_navigation', array('active'=>'inbox')); ?>
    
    <div class="messages-wrap">
        <div class="span8">
            <h2><?php echo UserModule::t('Inbox'); ?></h2>

                <?php $this->widget('bootstrap.widgets.TbGridView', array(
                    'id'=>'message-grid',
                    'type' => 'striped bordered condensed',
                    'htmlOptions'=>array('style'=>'padding-top: 0px;'),
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'rowCssClassExpression'=>'$data->is_read ? "read" : "unread"',
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
                            
                            /*'EQuickDlgs::ajaxLink(
                                            array(
                                                "controllerRoute" => "messages/view", 
                                                "actionParams" => array("message_id"=>$data->id), 
                                                "dialogTitle" => "Detailview",
                                                "dialogWidth" => 800,
                                                "dialogHeight" => 600,
                                                "openButtonText" => "$data->subject",
                                                "closeButtonText" => "Close",
                                            )
                                        );' 
                             * 
                             */
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
                        )
                    ),
                )); ?>
        </div>
    </div>
</div>
