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
			<span><?php echo $profile->firstname.' '.$profile->lastname; ?></span>
		</div>
		
		<div class="profile-onelinepitch">
			<span style="font-style:italic;"><?php echo $profile->resume; ?></span>
		</div>
		
		<div class="profile-sectors">
			<span><?php echo $model->getRoleNames(); ?></span>
		</div>
		
		<?php if($profile->facebook): ?>
			<a href="<?php echo $profile->facebook; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png'?>" style="margin-right:3px;"/></a>
		<?php endif; ?>
		
		<?php if($profile->twitter): ?>
			<a href="<?php echo $profile->twitter; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png'?>" style="margin-right:3px;"/></a>
		<?php endif; ?>
		
		<?php if($profile->linkedin): ?>
			<a href="<?php echo $profile->linkedin; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png'?>" style="margin-right:3px;"/></a>
		<?php endif; ?>
		
	
	</div>
	
	<div class="profile-header-right">
			
		<!--depois colocar aqui o FOLLOW-->	
        <?php if(UserModule::isAdmin() || $model->id == Yii::app()->user->id): ?>
			<span class="edit-btn">
			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Edit',
				'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'normal', // null, 'large', 'small' or 'mini'
				'url'=>array('edit','username'=>$model->username),
				'htmlOptions'=>array('style'=>'width:50px;'),
					)); 
				?>
			</span>
        <?php endif; ?>
        
	</div>
</div>
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-book profile-icon"></i> What I do</div>
		
		<div class="content-info">
			
			<p> <?php echo '<b>Working experiences: </b>'; ?>    
				
				<?php echo $profile->experiences; ?>  
			</p> 
            
            <p> <?php echo '<b>Skills: </b>'; ?>    
				
				<?php echo $model->getSkillNames(); ?>  
			</p> 
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head">What I am looking for</div>
		
		<div class="content-info">
			<p> <?php echo '<b>Interests: </b>'; ?>    
				
				<?php echo $profile->interests; ?>  
			</p> 
            
            <p> <?php echo '<b>Sectors of interest: </b>'; ?>    
				
				<?php echo $model->getSectorNames(); ?>  
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
				
				<?php echo $profile->telephone; ?>  
			</p> 
            
            <p> <?php echo '<b>Skype: </b>'; ?>    
				
				<?php echo $profile->skype; ?>  
			</p>
		
		</div>
		
	</div>	

	<div class="content-wrap">

		<div class="content-head">Personal</div>
		
		<div class="content-info">
            <p> <?php echo '<b>Gender: </b>'; ?>    
                <?php 
                    echo $profile->gender;
                ?>  
            </p>

            <p> <?php echo '<b>Birthday: </b>'; ?>    
                <?php 
                    echo $profile->birthday;
                ?>  
            </p>

            <p> <?php echo '<b>City: </b>'; ?>    
                <?php 
                    echo (isset($profile->location)) ? $profile->city->nome : '';
                ?>  
            </p>
	
		</div>
		
	</div>	
</div>


