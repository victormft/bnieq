<?php
Yii::app()->clientScript->registerScript('follow',
"


$('#yw0').click(function(event) {


		if($('#yw0').text()=='Follow')
		{	
			$('#yw0').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/follow?name='+getUrlVars()['name'],
				dataType: 'text',
				success: function(msg){
					$('#yw0').removeClass('btn-success');
					$('#yw0').text('Unfollow');	
				}
			});
		}
		
		else if($('#yw0').text()=='Unfollow')
		{
			$('#yw0').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/unfollow?name='+getUrlVars()['name'],
				success: function(){
					$('#yw0').addClass('btn-success');
					$('#yw0').text('Follow');		
				}
			});
		}
			
});


function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

");

?>


<div class="profile-header">	

	<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$model->logo0->name ?>" id="Startup-profile-img" alt="asdasd" />
	
	<div class="profile-header-info">
		
		<div class="profile-name">
			<span><?php echo $model->name; ?></span>
		</div>
		
		<div class="profile-onelinepitch">
			<span style="font-style:italic;"><?php echo $model->one_line_pitch; ?></span>
		</div>
		
		<div class="profile-sectors">
			<span><?php echo $model->getSectorNames(); ?></span>
		</div>
		
		<?php if($model->facebook): ?>
			<a href="<?php echo $model->facebook; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png'?>" style="margin-right:3px;"/></a>
		<?php endif; ?>
		
		<?php if($model->twitter): ?>
			<a href="<?php echo $model->twitter; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png'?>" style="margin-right:3px;"/></a>
		<?php endif; ?>
		
		<?php if($model->linkedin): ?>
			<a href="<?php echo $model->linkedin; ?>" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png'?>" style="margin-right:3px;"/></a>
		<?php endif; ?>
		
	
	</div>
	
	<div class="profile-header-right">
		
			
			<span class="follow-btn">
			
			
				
				<?php 
					
					if(!$model->hasUserFollowing(Yii::app()->user->id))
					{
						$this->widget('bootstrap.widgets.TbButton', array(
						'label'=>'Follow',
						'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						'size'=>'normal', // null, 'large', 'small' or 'mini'
						'url'=>'',//array('follow','name'=>$model->name),
						'htmlOptions'=>array('style'=>'width:50px;'),
						)); 
					}
					
					else
					{
						$this->widget('bootstrap.widgets.TbButton', array(
						'label'=>'Unfollow',
						'size'=>'normal', // null, 'large', 'small' or 'mini'
						'url'=>'',//array('unfollow','name'=>$model->name),
						'htmlOptions'=>array('style'=>'width:50px;'),
						)); 
					}
				?>
			<div class="follow-status">Followers: <div class="follow-count" style="display:inline;"><?php echo count($model->users); ?></div></div>
			</span>
			
			
			
			<span class="edit-btn">
			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Edit',
				'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'normal', // null, 'large', 'small' or 'mini'
				'url'=>array('edit','name'=>$model->name),
				'htmlOptions'=>array('style'=>'width:50px;'),
					)); 
				?>
			</span>
			
			
		
	</div>
	

</div>
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-book profile-icon"></i> Product Description</div>
		
		<div class="content-info">
			
			<?php echo $model->product_description;?> 
			
		</div>
		
	</div>	
	
	
	
	
	<div class="content-wrap">

		<div class="content-head">Sector and Location</div>
		
		<div class="content-info">
			<p> <?php echo '<b>Sector: </b>'; ?>    
				
				<?php 
					echo $model->getSectorNames();
				?>  
			</p>
			
			<div class="sectors_wrap">
				<?php $this->renderPartial('_sectors', array('model'=>$model)); ?>
			</div>
			
			<p> <?php echo '<b>Location: </b>'; ?>    
				<?php 
					echo $model->location;
				?>  
			</p>
			
			<p> <?php echo '<b>Post Code: </b>'; ?>    
				<?php 
					//echo $model->post_code;
				?>  
			</p>
			
			<p> <?php echo '<b>City: </b>'; ?>    
				<?php 
					//echo $model->city;
				?>  
			</p>
		</div>
		
	</div>	

	<div class="content-wrap">

		<div class="content-head"><i class="icon-search"></i> Company</div>
		
		<div class="content-info">
			 <p> <?php echo '<b>One Line Pitch: </b>'; ?>    
				<?php 
					echo $model->one_line_pitch;
				?>  
			</p>
			
			<p> <?php echo '<b>Company Size: </b>'; ?>    
				<?php 
					echo $model->company_size;
				?> 
			</p>
			
			<p> <?php echo '<b>Company Stage: </b>'; ?>    
				<?php 
					echo $model->company_stage;
				?> 
			</p>
			
			 <p> <?php echo '<b>Foundation: </b>'; ?>    
				<?php 
					echo $model->foundation;
				?>  
			</p>
			
			<p> <?php echo '<b>Email: </b>'; ?>    
				<?php 
					echo $model->email;
				?>  
			</p>
			
			<p> <?php echo '<b>Telephone: </b>'; ?>    
				<?php 
					echo $model->telephone;
				?>  
			</p>
			
			<p> <?php echo '<b>Skype: </b>'; ?>    
				<?php 
					echo $model->skype;
				?>  
			</p>
			
			<p> <?php echo '<b>Company Number: </b>'; ?>    
				<?php 
					echo $model->company_number;
				?>  
			</p>
		 
		</div>
		
	</div>	

</div>

<div class="profile-column-r">

	<div class="content-wrap">

		<div class="content-head"><i class="icon-road profile-icon"></i> Company Stage</div>
		
		<div class="content-info" style="text-align:center;">
			
			<?php
			
				if($model->company_stage=='Startup')
				{
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>33, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'danger',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo '<br /><b>Stage 1:</b> Startup';
				}
				
				else if($model->company_stage=='Early Stage')
				{
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>66, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'warning',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo '<br /><b>Stage 2:</b> Early Stage';
				}
				
				else if($model->company_stage=='Growth Stage')
				{	
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>100, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'success',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo '<br /><b>Stage 3:</b> Growth Stage';
				}
			?>
		
		</div>
		
	</div>	

	<div class="content-wrap">

		<div class="content-head">Private Profile!!!!!!!!!!! - Business Model</div>
		
		<div class="content-info">
		<p> <?php echo '<b>Client Segment: </b>'; ?>    
        <?php 
			echo $model->client_segment;
		?>  
    </p>
	
	<p> <?php echo '<b>Value Proposition: </b>'; ?>    
        <?php 
			echo $model->value_proposition;
		?>  
    </p>
	
	<p> <?php echo '<b>Market Size: </b>'; ?>    
        <?php 
			echo $model->market_size;
		?>  
    </p>
	
	<p> <?php echo '<b>Sales/Marketing Proposition: </b>'; ?>    
        <?php
			echo $model->sales_marketing;
		?>  
    </p>
	
	<p> <?php echo '<b>Revenue Generation: </b>'; ?>    
        <?php 
			echo $model->revenue_generation;	
		?>  
    </p>
	
	<p> <?php echo '<b>Competitors: </b>'; ?>    
        <?php 
			echo $model->competitors;
		?>  
    </p>
	
	<p> <?php echo '<b>Competitive Advantage: </b>'; ?>    
        <?php 
			echo $model->competitive_advantage;
		?>  
    </p>
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head">Header</div>
		
		<div class="content-info">
		Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum 
		</div>
		
	</div>	

</div>
<!--
	<b><?php echo CHtml::encode($model->getAttributeLabel('one_line_pitch')); ?>:</b>
	<?php echo CHtml::encode($model->one_line_pitch); ?>
	<br />

	
	<b><?php echo CHtml::encode($model->getAttributeLabel('foundation')); ?>:</b>
	<?php echo CHtml::encode($model->foundation); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($model->email); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('telephone')); ?>:</b>
	<?php echo CHtml::encode($model->telephone); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('skype')); ?>:</b>
	<?php echo CHtml::encode($model->skype); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('company_number')); ?>:</b>
	<?php echo CHtml::encode($model->company_number); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('facebook')); ?>:</b>
	<?php echo CHtml::encode($model->facebook); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('twitter')); ?>:</b>
	<?php echo CHtml::encode($model->twitter); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('linkedin')); ?>:</b>
	<?php echo CHtml::encode($model->linkedin); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($model->location); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('client_segment')); ?>:</b>
	<?php echo CHtml::encode($model->client_segment); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('value_proposition')); ?>:</b>
	<?php echo CHtml::encode($model->value_proposition); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('market_size')); ?>:</b>
	<?php echo CHtml::encode($model->market_size); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('sales_marketing')); ?>:</b>
	<?php echo CHtml::encode($model->sales_marketing); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('revenue_generation')); ?>:</b>
	<?php echo CHtml::encode($model->revenue_generation); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('competitors')); ?>:</b>
	<?php echo CHtml::encode($model->competitors); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('competitive_advantage')); ?>:</b>
	<?php echo CHtml::encode($model->competitive_advantage); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('video')); ?>:</b>
	<?php echo CHtml::encode($model->video); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($model->create_time); ?>
	<br />
-->
	 

