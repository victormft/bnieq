<?php $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
    <div class="modal-header" style="overflow-y: auto;">
        <a class="close" data-dismiss="modal">&times;</a>
    </div>
 
    <div class="modal-body">
		<?php Yii::app()->runController('messages/composewithid/id/'.$receiver->id); ?>
    </div>
 
    <div class="modal-footer">
   
    </div>
 
<?php $this->endWidget(); ?>
<?php 
echo "<button class='btn-msg-wrap' type='button'>";
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'label' => 'Message',
        'type' => 'warning',
        'size'=>'normal',
        'htmlOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#myModal',
            'style' => 'width:70px; padding:12px 5px;',
        ),
    )
);
echo "</button>";