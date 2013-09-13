<?php
$this->layout='//layouts/column1';

$this->breadcrumbs=array(
	'Users'=>array('/user/user'),
	$model->id,
); 
?>

<div class="profile-header">	

	
	<div class="profile-header-info">
		
		<div class="profile-name">
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
		</div>
        
		
		<div class="profile-onelinepitch" id="resume">
			<span style="font-style:italic;">
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
            </span>
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
		
		<div class="profile-sectors">
			<span>
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
            </span>
		</div>
		
        <div class="facebook">
            <img src=<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png>';?>
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
		
        <div class="twitter">
            <img src=<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png>';?>
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
            <img src=<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png>';?>
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
	
	</div>
	
	<div class="profile-header-right">
			
		<!--depois colocar aqui o FOLLOW-->	
        
			<span class="edit-btn">			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>'Profile',
                    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size'=>'normal', // null, 'large', 'small' or 'mini'
                    'url'=> Yii::app()->homeUrl . '/user/profile?username=' . $model->username,
                    'htmlOptions'=>array('style'=>'width:50px;'),
                    )); 
                ?>
			</span>
	</div>
</div>
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-book profile-icon"></i> What I do</div>
		
		<div class="content-info">
			
			<p> <?php echo '<b>Working experiences: </b>'; ?>    
				
				<?php $this->widget('editable.EditableField', array(
                    'type'      => 'textarea',
                    'model'     => $profile,
                    'attribute' => 'experiences',
                    'url'       => array('updateEd'),  
                    'placement' => 'right',
                 )); ?>  
			</p> 
            
            <p> <?php echo '<b>Skills: </b>'; ?>    
				
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
			</p> 
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head">What I am looking for</div>
		
		<div class="content-info">
			<p> <?php echo '<b>Interests: </b>'; ?>    
				
				<?php $this->widget('editable.EditableField', array(
                    'type'      => 'textarea',
                    'model'     => $profile,
                    'attribute' => 'interests',
                    'url'       => array('updateEd'),  
                    'placement' => 'right',
                 )); ?>    
			</p> 
            
            <p> <?php echo '<b>Sectors of interest: </b>'; ?>    
				
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
			</p> 
            
		</div>
		
	</div>	
</div>
    
<div class="profile-column-r">

	<div class="content-wrap">

		<div class="content-head"><i class="icon-road profile-icon"></i>Contacts</div>
		
		<div class="content-info">
			
			<p> <?php echo '<b>Email: </b>'; ?>    
				
				<?php echo $model->email; ?>  
			</p> 
            
            <p> <?php echo '<b>Telephone: </b>'; ?>    
				
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
            
            <p> <?php echo '<b>Skype: </b>'; ?>    
				
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
		
	</div>	

	<div class="content-wrap">

		<div class="content-head">Personal</div>
		
		<div class="content-info">
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

            <p> <?php echo '<b>Birthday: </b>'; ?>    
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

            <p> <?php echo '<b>City: </b>'; ?>    
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
		
	</div>	
</div>


