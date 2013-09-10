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

<div id="resume" style="width: 500px;">
<?php
    $this->widget('editable.EditableField', array(
        'type'      => 'textarea',
        'model'     => $profile,
        'attribute' => 'resume',
        'url'       => array('updateEd'),  
        'placement' => 'right',
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
            $('#resume').tooltip('show')
        });	
        $('#resume3').on('hidden', function(e, editable) {
            $('#resume').tooltip('hide')
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
        'inputclass'=> 'input-large'
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
        'mode'      => 'inline',
        'inputclass'=> 'input-large'
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
        'mode'      => 'inline',
        'inputclass'=> 'input-large'
     ));?>
         
</div>


<h3>What I do</h3>
<div class="">
    <p> <?php echo '<b>Working experiences: </b>'; ?>    
        <?php $this->widget('editable.EditableField', array(
            'type'      => 'textarea',
            'model'     => $profile,
            'attribute' => 'experiences',
            'url'       => array('updateEd'),  
            'placement' => 'right',
         )); ?>    
    </p>
     
    <div class="">
        <?php echo '<b>Skills:</b> '; ?>
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
    <p> <?php echo '<b>Interests: </b>'; ?>    
        <?php $this->widget('editable.EditableField', array(
            'type'      => 'textarea',
            'model'     => $profile,
            'attribute' => 'interests',
            'url'       => array('updateEd'),  
            'placement' => 'right',
         )); ?>    
    </p>
    
    <div class="">
        <?php echo '<b>Sectors of interest:</b> '; ?>
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
    <p> <?php echo '<b>Birthday: </b>'; ?>    
        <?php $this->widget('editable.EditableField', array(
            'type'      => 'date',
            'model'     => $profile,
            'attribute' => 'birthday',
            'url'       => array('updateEd'),  
            'placement' => 'right',
            'format'      => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
            'viewformat'  => 'dd/mm/yyyy', //format in which date is displayed
         )); ?>  
    </p>
    
    <p> <?php echo '<b>Gender: </b>'; ?>    
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
    
    <p> <?php echo '<b>Location: </b>'; ?> 
                    
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
    <p><?php echo '<b>Email: </b>' . $model->email; ?></p>
    
    <p>
        <?php echo '<b>Telephone: </b>'?>
        <?php 
        $this->widget('editable.EditableField', array(
            'type'      => 'text',
            'model'     => $profile,
            'attribute' => 'telephone',
            'url'       => array('updateEd'),  
            'placement' => 'right',
         )); ?>  
    </p>
    
    <p>
        <?php echo '<b>Skype: </b>'?>
        <?php $this->widget('editable.EditableField', array(
            'type'      => 'text',
            'model'     => $profile,
            'attribute' => 'skype',
            'url'       => array('updateEd'),  
            'placement' => 'right',
         )); ?>  
    </p>
    
    
</div>


    