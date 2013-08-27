<div class="roles">
    <?php echo $model->getRoleNames(); ?>
    
    <button type="button" data-toggle="modal" data-target="#myModal">Launch modal</button>
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
                
                <?php $this->widget('bootstrap.widgets.TbSelect2', array(
                    'name' => 'rolesU',        
                    'data' => Role::model()->getOptions(),
                    'value'=> Role::model()->getOptionsIds($model->id),
                    'options' => array(
                        'placeholder' => 'Select your Roles...',
                        'width' => '40%',
                        'tokenSeparators' => array(',', ' '),
                    ),
                    'htmlOptions'=>array(
                        'multiple'=>'multiple',
                        'class'=>'controls',
                ))); ?>
                
                <legend>Links</legend>
    
                    <?php echo $form->textFieldRow($profile, 'facebook', array('class'=>'span5')); ?>

                    <?php echo $form->textFieldRow($profile, 'linkedin', array('class'=>'span5')); ?>

                    <?php echo $form->textFieldRow($profile, 'twitter', array('class'=>'span5')); ?>

                        
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
