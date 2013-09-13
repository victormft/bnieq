<?php 

$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");

$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user/user')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);

?>

<?php
    $this->widget('editable.EditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'firstname',
        'url'       => array('updateEd'),  //url for submit data          
        'placement' => 'right',
        'htmlOptions'=>  array(
            'style' => 'font-size: 28px; font: bold',
        )
     ));
     echo ' ';
     $this->widget('editable.EditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'lastname',
        'url'       => array('updateEd'),             
        'placement' => 'right',
        'htmlOptions'=>  array(
            'style' => 'font-size: 28px; font: bold',
        )
     ));
?>

<span class="edit-btn">			
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Edit',
        'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'=>'normal', // null, 'large', 'small' or 'mini'
        'url'=>Yii::app()->homeUrl . '/user/profile/' . Yii::app()->user->id,
        'htmlOptions'=>array('style'=>'width:50px;'),
        )); 
    ?>
</span>

<div id="resume" style="width: 500px;">
<?php
    $this->widget('editable.EditableField', array(
        'type'      => 'textarea',
        'model'     => $profile,
        'attribute' => 'resume',
        'url'       => array('updateEd'),  
        'mode'      => 'inline', 
        'htmlOptions'=> array(
            'id' => 'resume3'
        ),
        'options'    => array(
            'rows'      => 4,
        )
     ));
?>
</div>

<script type='text/javascript'>	
    $(function() {
        $('#resume').tooltip({
            trigger: 'manual', 
            placement: 'right', 
            title: '<h2>Vou colocar um render aqui</h2>',
            html: true,
        });
        $('#resume3').on('shown', function(e, editable) {
            $('#resume').tooltip('show');
        });	
        $('#resume3').on('hidden', function(e, editable) {
            $('#resume').tooltip('hide');
        });	
    });
</script>

<?php           
    $this->widget('editable.Editable', array(
        'type'      => 'select2',
        'name'      => 'role',
        'pk'        => $model->id,
        'url'       => $this->createUrl('updateRoles'), 
        'source'    => CHtml::listData(Role::model()->findAll(), 'role_id', 'name'),
        'text'      => $model->getRoleNames(),  
        'value'     => $model->getRoleIds(),
        'placement' => 'right',
        'inputclass'=> 'input-large',
        'select2'   => array(
            'placeholder'=> 'Select...',
            'multiple'=>true,
        ),
    )); ?>

<div class="facebook" style="width: 700px">
    <img src=<?php echo Yii::app()->request->baseUrl.'/images/Facebook-icon-32.png>';?>
    <?php
    $this->widget('editable.EditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'facebook',
        'url'       => array('updateEd'),  //url for submit data          
        'placement' => 'right',
        'inputclass'=> 'input-large',
        'options'=>array(
            'defaultValue'=>'https://www.facebook.com/'
        )
     ));?>
         
</div>

<div class="linkedin">
    <img src=<?php echo Yii::app()->request->baseUrl.'/images/Linkedin-icon-32.png>';?>
    <?php
    $this->widget('editable.EditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'linkedin',
        'url'       => array('updateEd'),  //url for submit data          
        'placement' => 'right',
        'inputclass'=> 'input-large',
        'options'=>array(
            'defaultValue'=>'http://www.linkedin.com/pub/'
        )
     ));?>
         
</div>

<div class="twitter">
    <img src=<?php echo Yii::app()->request->baseUrl.'/images/Twitter-icon-32.png>';?>
    <?php
    $this->widget('editable.EditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'twitter',
        'url'       => array('updateEd'),  //url for submit data          
        'placement' => 'right',
        'inputclass'=> 'input-large',
        'options'=>array(
            'defaultValue'=>'https://twitter.com/'
        )
     ));?>
         
</div>


<h3>What I do</h3>
<div class="">
    <p> <?php echo CHtml::encode('Working experiences: '); ?>    
        <?php $this->widget('editable.EditableField', array(
            'type'      => 'textarea',
            'model'     => $profile,
            'attribute' => 'experiences',
            'url'       => array('updateEd'),  
            'placement' => 'right',
         )); ?>    
    </p>
     
    <div class="">
        <?php echo CHtml::encode('Skills: '); ?>
        <?php           
            $this->widget('editable.Editable', array(
                'type'      => 'select2',
                'name'      => 'skill',
                'pk'        => $model->id,
                'url'       => $this->createUrl('updateSkills'), 
                'source'    => CHtml::listData(Skill::model()->findAll(), 'skill_id', 'name'),
                'text'      => $model->getSkillNames(),  
                'value'     => $model->getSkillIds(),
                'placement' => 'right',
                'inputclass'=> 'input-large',
                'select2'   => array(
                    'placeholder'=> 'Select...',
                    'multiple'=>true,
                ),
            )); ?>
        
    </div>
</div>

<h3>What I'm looking for</h3>
<div class="interests">
    <p> <?php echo CHtml::encode('Interests: '); ?>    
        <?php $this->widget('editable.EditableField', array(
            'type'      => 'textarea',
            'model'     => $profile,
            'attribute' => 'interests',
            'url'       => array('updateEd'),  
            'placement' => 'right',
         )); ?>    
    </p>
    
    <div class="">
        <?php echo CHtml::encode('Sectors of interest: '); ?>
        <?php           
            $this->widget('editable.Editable', array(
                'type'      => 'select2',
                'name'      => 'sector',
                'pk'        => $model->id,
                'url'       => $this->createUrl('updateSectors'), 
                'source'    => CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'),
                'text'      => $model->getSectorNames(),  
                'value'     => $model->getSectorIds(),
                'placement' => 'right',
                'inputclass'=> 'input-large',
                'select2'   => array(
                    'placeholder'=> 'Select...',
                    'multiple'=>true,
                ),
            )); ?>
        
    </div>
</div>

<h3>Personal</h3>
<div class="">
    <p> <?php echo CHtml::encode('Birthday: '); ?>    
        <?php $this->widget('editable.EditableField', array(
            'type'      => 'combodate',
            'model'     => $profile,
            'attribute' => 'birthday',
            'url'       => array('updateEd'),  
            'placement' => 'right',
            'mode'      => 'inline',
            'format'      => 'YYYY-MM-DD', //format in which date is expected from model and submitted to server
            'viewformat'  => 'DD/MM/YYYY', //format in which date is displayed
            'template'    => 'D / MMM / YYYY',
            'options'   => array(
                'defaultValue'   => date('Y-m-d'),
            )
         )); ?>  
    </p>
    
    <p> <?php echo CHtml::encode('Gender: '); ?>    
        <?php $this->widget('editable.EditableField', array(
            'type'      => 'select',
            'model'     => $profile,
            'attribute' => 'gender',
            'url'       => array('updateEd'),  
            'source'    => array(
                'M' => 'Male',
                'F' => 'Female',
            ), 
            'placement' => 'right',
            'options'   => array(
                'prepend'   => '',
            )    
         )); ?> 
    </p>
    
    <p> <?php echo CHtml::encode('City: '); ?>                     
        <?php           
        $this->widget('editable.EditableField', array(
            'type'      => 'select2',
            'model'     => $profile,
            'attribute' => 'location',
            'url'       => $this->createUrl('updateLocation'), 
            'source'    => Cidade::model()->getCities(),
            'placement' => 'right',
            'inputclass'=> 'input-large',
            'select2'   => array(
                'placeholder'=> 'Select...',
                'allowClear'=> true,   
                'dropdownAutoWidth'=> true,
                'minimumInputLength'=> 3,
            )
        )); ?>
               
    </p>
</div>

<h3>Contacts</h3>
<div class="">
    <p><?php echo CHtml::encode('Email: ') . $model->email; ?></p>
    
    <p>        
        <?php echo CHtml::encode('Telephone: '); ?>
        <?php 
        $this->widget('editable.EditableField', array(
            'type'      => 'text',
            'model'     => $profile,
            'attribute' => 'telephone',
            'url'       => array('updateEd'),  
            'placement' => 'right',
            'title'     =>'Apenas números ou + no início',
            'options'=>  array(
                'tpl'=> '<input type="text" maxlength="30">'
            ),         
         )); ?>                 
    </p>    
    
    <p>
        <?php echo CHtml::encode('Skype: '); ?>
        <?php $this->widget('editable.EditableField', array(
            'type'      => 'text',
            'model'     => $profile,
            'attribute' => 'skype',
            'url'       => array('updateEd'),  
            'placement' => 'right',
            'options'=>  array(
                'tpl'=> '<input type="text" maxlength="45">'
            ),
         )); ?>  
    </p>
    
    
</div>


    