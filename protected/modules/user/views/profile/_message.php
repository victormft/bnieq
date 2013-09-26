<?php $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
    </div>
 
    <div class="modal-body">
		<?php Yii::app()->runController('messages/composewithid/id/'.$receiver->id); ?>
    </div>
 
    <div class="modal-footer">
   
    </div>
 
<?php $this->endWidget(); ?>
<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => 'Message',
        'type' => 'primary',
        'htmlOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#myModal',
        ),
    )
);