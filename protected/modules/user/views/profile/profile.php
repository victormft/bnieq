<?php
$this->layout='//layouts/column1';

?>

<?php
Yii::app()->clientScript->registerScript('follow',
"
$('#yw0').click(function(event) {

		if($('#yw0').text()==='Follow')
		{	
			$('#yw0').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');			
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/user/user/follow?username='+getUrlVars()['username'],
				dataType: 'json',
				success: function(data){
					$('#yw0').removeClass('btn-success');
					$('#yw0').text('Unfollow');	
                    $('.follow-count').html(data.res);
				}
			});
		}
		
		else if($('#yw0').text()==='Unfollow')
		{
			$('#yw0').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/user/user/unfollow?username='+getUrlVars()['username'],
                dataType: 'json',
				success: function(data){
					$('#yw0').addClass('btn-success');
					$('#yw0').text('Follow');
                    $('.follow-count').html(data.res);
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

$('.arrow-container').mouseover(function(event){
		$(this).css('background-color', '#fefefe');
	});
	
	$('.arrow-container').mouseout(function(event){
		$(this).css('background-color', '#f6f6f6');
	});
	
	$('.content-head').click(function(event){
		
		if(!$(this).hasClass('clicked'))
		{
			$(this).removeClass('rounded');
			$(this).next().slideDown();
			$(this).addClass('clicked');
			$(this).find('.arrow').removeClass('arrow-down');
			$(this).find('.arrow').addClass('arrow-up');
		}
		
		else
		{
			$(this).next().slideUp(function(){
				$(this).prev().addClass('rounded');
			});
			$(this).removeClass('clicked');
			$(this).find('.arrow').removeClass('arrow-up');
			$(this).find('.arrow').addClass('arrow-down');
			
		}
		
	});

");

?>

<?php if(Yii::app()->user->hasFlash('messageModule')): ?>
    <?php 
    $this->widget(
        'bootstrap.widgets.TbBadge',
        array(
            'type' => 'success',
            // 'success', 'warning', 'important', 'info' or 'inverse'
            'label' => Yii::app()->user->getFlash('messageModule'),
        )
    ); ?>

<?php endif; ?>

<div class="profile-header">	
    
    <img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$profile->logo->name ?>" id="user-profile-img">
	
	<div class="user-profile-header-info">     

        <div class="profile-name">
            <span><?php echo $profile->firstname.' '.$profile->lastname; ?></span>
        </div>

        <div class="user-profile-onelinepitch">
            <span><?php echo $profile->resume; ?></span>
        </div>

        <div class="user-profile-location">
            <i class="icon-map-marker profile-icon"></i><a href="#"><?php if (isset($profile->city)) echo $profile->city->nome; ?></a>
        </div>

        <div class="user-profile-sectors">
            <?php echo $model->getRolesForPrint(); ?>
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
			
        <?php if(Yii::app()->user->checkAccess('followUser', array('userid'=>$model->id))): ?>
		<span class="follow-btn">
            
            <div class="follow-info">
                <div class="follow-count"><?php echo count($model->followers); ?></div><div class="follow-status">Followers</div>
            </div>
            <?php 
                if(!$model->hasUserFollowing(Yii::app()->user->id))
                {
                    $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>'Follow',
                    'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size'=>'normal', // null, 'large', 'small' or 'mini'
                    'url'=>'',//array('follow','name'=>$model->name),
                    'htmlOptions'=>array('style'=>'width:50px; padding-top:12px; padding-bottom:12px;'),
                    )); 
                }
                else
                {
                    $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>'Unfollow',
                    'size'=>'normal', // null, 'large', 'small' or 'mini'
                    'url'=>'',//array('unfollow','name'=>$model->name),
                    'htmlOptions'=>array('style'=>'width:50px; padding-top:12px; padding-bottom:12px;'),
                    )); 
                }
                
                if($model->id !== Yii::app()->user->id) $this->renderPartial('_message', array('receiver'=>$model));
            ?>
        </span>
        <?php endif; ?>
        
        <?php if(Yii::app()->user->checkAccess('updateSelf', array('userid'=>$model->id))): ?>
			<span class="edit-btn">
			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Editar',
				'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'normal', // null, 'large', 'small' or 'mini'
				'url'=>array('edit','username'=>$model->username),
				'htmlOptions'=>array('style'=>'width:50px;'),
					)); 
				?>
                
			</span>
        <?php endif; ?>
        
        
        
        <?php //if($model->id !== Yii::app()->user->id): ?>
        <?php //$this->widget('bootstrap.widgets.TbButton', array(
            //'label'=>'Message',
            //'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            //'size'=>'normal', // null, 'large', 'small' or 'mini'
            //'url'=>array('/messages/compose','id'=>$model->id),
            //'htmlOptions'=>array('style'=>'width:50px;'),
           //     )); 
            ?>
        <?php //endif; ?>
        
	</div>
</div>
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head clicked">
            <i class="icon-road profile-icon"></i>O que eu faço
        </div>
		
		<div class="content-info">
            
            <div class="content-info-unit">         
                <div class="clabel">			
                    <?php echo '<b>Experiências: </b>'; ?>
                    <span class="tip">O que você já fez de mais interessante?</span>                    
                </div>
                <div class="editable-wrap-profile">		                    
                    <?php echo $profile->experiences; ?>  				
                </div>				 
            </div>
            
            <div class="content-info-unit">         
                <div class="clabel">			
                    <?php echo '<b>Skills: </b>'; ?>
                    <span class="tip">O que você faz de melhor?</span>                    
                </div>
                <div class="editable-wrap-profile">		                    
                    <?php echo $model->getSkillsForPrint(); ?>  				
                </div>				 
            </div>
			
		</div>
		
	</div>		
	
	<div class="content-wrap">

		<div class="content-head clicked">
            <i class="icon-search profile-icon"></i> O que eu procuro
        </div>
		
		<div class="content-info">
            
            <div class="content-info-unit">         
                <div class="clabel">			
                    <?php echo '<b>Interesses: </b>'; ?>
                    <span class="tip">O que te interessa?</span>                    
                </div>
                <div class="editable-wrap-profile">		                    
                    <?php echo $profile->interests; ?>  				
                </div>				 
            </div>
            
            <div class="content-info-unit">         
                <div class="clabel">			
                    <?php echo '<b>Setores de interesse: </b>'; ?> 
                    <span class="tip">Quais desses setores te interessam?</span>                    
                </div>
                <div class="editable-wrap-profile">		                    
                    <?php echo $model->getSectorsForPrint(); ?>  				
                </div>				 
            </div>
            
		</div>
		
	</div>	
</div>
    
<div class="profile-column-r">

<?php if($model->isReallyYou()): ?> 
    
	<div class="content-wrap">

		<div class="content-head clicked">
            <i class="icon-circle-arrow-up profile-icon"></i>Startups & Pitches
        </div>
		
		<div class="content-info">
            
            <div class="content-info-unit">         
                <div class="clabel">			
                    <?php echo 'COMMING SOON...'; ?>                   
                </div>			 
            </div>
            
		</div>
    </div>  
    
<?php endif; ?>     
    
    <div class="content-wrap">
        
        <div class="content-head clicked">
            <i class="icon-circle-arrow-up profile-icon"></i>Referências & Follows
        </div>
		
		<div class="content-info">
            
            <div class="content-info-unit">         
                <div class="clabel">			
                    <?php echo 'COMMING SOON...'; ?>                   
                </div>			 
            </div>
            
		</div>
    </div>
		
    
<?php if($model->isReallyYou()): ?>    
    
    <div class="content-wrap">   
        
        <div class="content-head clicked">
            <i class="icon-book profile-icon"></i>Contatos
        </div>
        
		<div class="content-info">
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Telefone: </b>'; ?>                   
                </div>
                <div class="editable-wrap-r">			
                    <?php echo $profile->telephone; ?>  				
                </div>
            </div>
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Skype: </b>'; ?>                    
                </div>
                <div class="editable-wrap-r">			
                    <?php echo $profile->skype; ?>				
                </div>
            </div>        
		</div>
		
	</div>	

    <div class="content-wrap">   
        
        <div class="content-head clicked">
            <i class="icon-smile profile-icon"></i>Pessoal
        </div>
        
		<div class="content-info">
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Sexo: </b>'; ?>                   
                </div>
                <div class="editable-wrap-r">			
                    <?php 
                    if($profile->gender === 'M') echo 'Male';
                    elseif($profile->gender === 'F') echo 'Female';
                    else echo 'not selected...';
                    ?>                        
                </div>
            </div>
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Data de nascimento: </b>'; ?>                    
                </div>
                <div class="editable-wrap-r">			
                    <?php echo (isset($profile->birthday)) ? date('d-F-Y', strtotime($profile->birthday)) : 'not selected...'; ?>				
                </div>
            </div>        
		</div>
		
	</div>


<?php endif; ?>

</div>
