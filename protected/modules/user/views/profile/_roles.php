<div class="roles">
    <?php echo $model->getRoleNames(); ?>
    
    <?php echo (!UserModule::isAdmin() && $model->id !== Yii::app()->user->id) ? 
        '' : '<button type="button" data-toggle="modal" data-target="#myModal">Launch modal</button>'; ?>
    
    
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                
                <?php echo CHtml::checkBoxList('roles', Role::model()->getOptionsIds($model->id), 
                    CHtml::listData(Role::model()->findAll(), 'role_id', 'name'), array('labelOptions'=>array('style'=>'display:inline'))
                ); ?>
                                
                <legend>Links</legend>
    
                    <?php echo $form->textFieldRow($profile, 'facebook', array('class'=>'span3')); ?>

                    <?php echo $form->textFieldRow($profile, 'linkedin', array('class'=>'span3')); ?>

                    <?php echo $form->textFieldRow($profile, 'twitter', array('class'=>'span3')); ?>

                        
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal">Close</a>
                            <?php echo CHtml::ajaxSubmitButton('Save', array('editroles', 'id'=>$model->id), array('update'=>'.roles'),
                                 array("class"=>"btn btn-primary btn-large", "data-dismiss"=>"modal")
                            );
                            ?>
                    </div>
                
                    <?php $this->endWidget(); ?>
                </div>
                <!-- form -->
        </div>
    </div>   
    
    <div class="socials">    
        <a href=<?php echo $profile->facebook; ?>> <img src=<?php echo Yii::app()->request->baseUrl.'/images/facebook.png>';?> </a>
        <a href=<?php echo $profile->linkedin; ?>> <img src=<?php echo Yii::app()->request->baseUrl.'/images/linkedin.png>';?> </a>
        <a href=<?php echo $profile->twitter; ?>> <img src=<?php echo Yii::app()->request->baseUrl.'/images/twitter.png>';?> </a>
    </div>
</div>
