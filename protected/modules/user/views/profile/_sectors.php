<div class="sectors">
    
    <?php echo '<b>Sectors of interest:</b>'; ?>
    <?php echo $model->getSectorNames(); ?>
    
    <button type="button" data-toggle="modal" data-target="#sectors">Launch modal</button>
    <div id="sectors" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h3 id="myModalLabel">Modal header</h3>
        </div>
        <div class="modal-body">           
            <div class="form">                
                <?php /** @var BootActiveForm $form */
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'horizontalForm',
                    'type'=>'horizontal',
                )); ?>
                
                    <?php echo CHtml::checkBoxList('sectors', Sector::model()->getOptionsIds($model->id), 
                        CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'), array('labelOptions'=>array('style'=>'display:inline'))
                    ); ?>

                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal">Close</a>
                            <?php echo CHtml::ajaxSubmitButton('Save', array('editsectors', 'id'=>$model->id), array('update'=>'.sectors'),
                                 array("class"=>"btn btn-primary btn-large", "data-dismiss"=>"modal")
                            );
                            ?>
                    </div>
                
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>   
</div>