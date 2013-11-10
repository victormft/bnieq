<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t($model->getFullName()); ?>

<?php
$this->layout='//layouts/column1'; 
?>

<?php
Yii::app()->clientScript->registerScript('follow',
"
$('#followBtn').click(function(event) {

		if($('#followBtn').text()==='Follow')
		{	
			$('#followBtn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');			
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/user/user/follow?username=".$model->username."',
				dataType: 'json',
				success: function(data){
					$('#followBtn').removeClass('btn-success');
					$('#followBtn').text('Unfollow');	
                    $('.follow-count').html(data.res);
				}
			});
		}
		
		else if($('#followBtn').text()==='Unfollow')
		{
			$('#followBtn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/user/user/unfollow?username=".$model->username."',
                dataType: 'json',
				success: function(data){
					$('#followBtn').addClass('btn-success');
					$('#followBtn').text('Follow');
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
    
    <div id="startup-profile-img">
        <img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$profile->logo->name ?>">
	</div>
    
	<div class="user-profile-header-info">     

        <div class="profile-name">
            <span><?php echo $model->getFullName(); ?></span>
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
		
        <?php if($profile->website): ?>            
            <a href="<?php echo $profile->website; ?>" target="_blank" style="margin-left: 0.1px;"><div class="user-website"><i class="icon-globe"></i></div></a>
        <?php endif; ?>    
	</div>
	
	<div class="profile-header-right">
			
        
		<span class="follow-btn">
            
            <div class="follow-info">
                <div class="follow-count"><?php echo count($model->followers); ?></div><div class="follow-status"><?php echo UserModule::t('Followers'); ?></div>
            </div>
            
            <?php if(Yii::app()->user->checkAccess('followUser', array('userid'=>$model->id))): ?>
            <?php 
                if(!$model->hasUserFollowing(Yii::app()->user->id))
                {
                    $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>'Follow',
                    'id'=>'followBtn', 
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
                    'id'=>'followBtn', 
                    'size'=>'normal', // null, 'large', 'small' or 'mini'
                    'url'=>'',//array('unfollow','name'=>$model->name),
                    'htmlOptions'=>array('style'=>'width:50px; padding-top:12px; padding-bottom:12px;'),
                    )); 
                }
                //echo "<button class='btn-msg-wrap' type='button'>";
                EQuickDlgs::ajaxLink(
                    array(
                        'controllerRoute' => 'messages/composewithid', //'member/view'
                        'actionParams' => array('id'=>$model->id), //array('id'=>$model->member->id),
                        //'dialogTitle' => 'Detailview',
                        'dialogWidth' => 450,
                        'dialogHeight' => 500,
                        'openButtonText' => UserModule::t('Message'),
                        'closeButtonText' => 'Close',
                        'openButtonHtmlOptions' => array(
                            'style' => 'width:70px; padding:12px 5px; margin-left: 10px', 
                            'class' => 'btn btn-warning',
                        )
                    )
                );
                //echo "</button>";
                //if($model->id !== Yii::app()->user->id) $this->renderPartial('_message', array('receiver'=>$model));
            ?>
            <?php endif; ?>
        </span>
        
        
        <?php if(Yii::app()->user->checkAccess('updateSelf', array('userid'=>$model->id))): ?>
			<span class="edit-btn-user">
			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>UserModule::t('Edit'),
                    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size'=>'normal', // null, 'large', 'small' or 'mini'
                    'url'=>array('edit','username'=>$model->username),
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
            <i class="icon-briefcase profile-icon"></i> Porfolio
        </div>
		
		<div class="content-info">
            
            <div class="cards-wrap">
                <?php foreach($model->startups as $startup):  ?>
                <?php $relational_tbl=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$model->id, ':s_id'=>$startup->id)); ?>
                <?php if($relational_tbl->profile):?>
                <div class="startup-card">
                    <div class="startup-pic" style="overflow: auto;"><?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$startup->logo0->name.'"/>', array('/startup/view', 'name'=>$startup->startupname)); ?> </div>
                    <div class="startup-name"><?php echo CHtml::link($startup->name, array('/startup/view', 'name'=>$startup->startupname)); ?></div>
                    <div class="user-position"><?php echo ($relational_tbl->title === NULL || $relational_tbl->title === '') ? UserModule::t($relational_tbl->position) :  UserModule::t($relational_tbl->title);?></div>
                </div>
                <?php endif;  ?>
                <?php endforeach;  ?>
            </div>
            
            <?php if($model->isUserInRole('Founder')): ?>
            <div class="clabel-r">			
                <?php echo '<b>'.UserModule::t("Founder").':</b>'; ?>                    
            </div>
            <div class="profile-content">			
                <?php echo $model->echoWithComma($model->getStartupsByRole('Founder'));?>				
            </div>
            <?php endif; ?>
            
            <?php if($model->isUserInRole('Member')): ?>
            <div class="clabel-r">			
                <?php echo '<b>'.UserModule::t("Member").':</b>'; ?>                    
            </div>
            <div class="profile-content">			
                <?php echo $model->echoWithComma($model->getStartupsByRole('Member'));?>				
            </div>
            <?php endif; ?>
            
            <?php if($model->isUserInRole('Advisor')): ?>
            <div class="clabel-r">			
                <?php echo '<b>'.UserModule::t("Advisor").':</b>'; ?>                    
            </div>
            <div class="profile-content">			
                <?php echo $model->echoWithComma($model->getStartupsByRole('Advisor'));?>				
            </div>
            <?php endif; ?>
            
            <?php if($model->isUserInRole('Investor')): ?>
            <div class="clabel-r">			
                <?php echo '<b>'.UserModule::t("Investor").':</b>'; ?>                    
            </div>
            <div class="profile-content">			
                <?php echo $model->echoWithComma($model->getStartupsByRole('Investor'));?>				
            </div>
            <?php endif; ?>
            
            
			
		</div>
		
	</div>	
    
	<div class="content-wrap">

		<div class="content-head clicked">
            <i class="icon-road profile-icon"></i> O que eu faço
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
                    <?php echo '<b>'.UserModule::t('Skills').': </b>'; ?>
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
            <i class="icon-circle-arrow-up profile-icon"></i> Startups & Pitches
        </div>
		
		<div class="content-info">
            
            <div class="content-info-unit" style="text-align: center;">        
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                        'label'=>'Create Startup',
                        'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                        'size'=>'large', // null, 'large', 'small' or 'mini'
                        'url'=>$this->createUrl('/startup/create'),//array('unfollow','name'=>$model->name),
                    )); ?>
                <div class="clabel">
                    
                    <?php //echo 'COMMING SOON...'; ?>                   
                </div>			 
            </div>
            
		</div>
    </div>  
    
<?php endif; ?>     
    
    <div class="content-wrap">
        
        <div class="content-head clicked">
            <i class="icon-circle-arrow-up profile-icon"></i> <?php echo UserModule::t('References & Follows'); ?>
        </div>
		
		<div class="content-info" style="padding: 0;">            
            <div class="content-info-unit">
                <div class="follow-block">
                <?php EQuickDlgs::ajaxLink(
                    array(
                        'controllerRoute' => 'user/user/followpop',
                        'actionParams' => array('id'=>$model->id, 'follow'=>'ing', 'attr'=>'followed'),
                        'dialogTitle' => UserModule::t('Following'),
                        'dialogWidth' => 600,
                        'dialogHeight' => 500,
                        'openButtonText' => UserModule::t('Following'),
                        'closeButtonText' => 'Close', //uncomment to add a closebutton to the dialog
                    )
                );?>
                </div>
                <div class="follow-block">
                <?php EQuickDlgs::ajaxLink(
                    array(
                        'controllerRoute' => 'user/user/followpop',
                        'actionParams' => array('id'=>$model->id, 'follow'=>'stup'),
                        'dialogTitle' => 'Startups followed',
                        'dialogWidth' => 600,
                        'dialogHeight' => 500,
                        'openButtonText' => 'Startups',
                        'closeButtonText' => 'Close', //uncomment to add a closebutton to the dialog
                    )
                );?>
                </div>
                <div class="follow-block">
                <?php EQuickDlgs::ajaxLink(
                    array(
                        'controllerRoute' => 'user/user/followpop',
                        'actionParams' => array('id'=>$model->id, 'follow'=>'ers', 'attr'=>'follower'),
                        'dialogTitle' => UserModule::t('Followers'),
                        'dialogWidth' => 600,
                        'dialogHeight' => 500,
                        'openButtonText' => UserModule::t('Followers'),
                        'closeButtonText' => 'Close', //uncomment to add a closebutton to the dialog
                    )
                );?>
                </div>                		 
            </div>            
		</div>
    </div>
		
    
<?php if($model->isReallyYou()): ?>    
    
    <div class="content-wrap">   
        
        <div class="content-head clicked">
            <i class="icon-book profile-icon"></i> Contatos
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
            <i class="icon-smile profile-icon"></i> Pessoal
        </div>
        
		<div class="content-info">
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Sexo: </b>'; ?>                   
                </div>
                <div class="editable-wrap-r">			
                    <?php 
                    if($profile->gender === 'M') echo UserModule::t('Male');
                    elseif($profile->gender === 'F') echo UserModule::t('Female');
                    else echo UserModule::t('Not selected...');
                    ?>                        
                </div>
            </div>
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Data de nascimento: </b>'; ?>                    
                </div>
                <div class="editable-wrap-r">			
                    <?php echo (isset($profile->birthday)) ? Yii::app()->getDateFormatter()->format('d-MMMM-yyyy', $profile->birthday) : UserModule::t('Not selected...'); ?>				
                </div>
            </div>        
		</div>
		
	</div>


<?php endif; ?>

</div>
