<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t($model->getFullName()); ?>

<?php
$this->layout='//layouts/column1'; 
?>

<?php
Yii::app()->clientScript->registerScript('follow',
"
$('#followBtn').click(function(event) {
        var elem = $(this);
        
		if(elem.hasClass('follow'))
		{	
			$('#followBtn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');			
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/user/user/follow?username=".$model->username."',
				dataType: 'json',
				success: function(data){
					$('#followBtn').removeClass('btn-success');
                    $('#followBtn').removeClass('follow');
                    $('#followBtn').addClass('unfollow');
					$('#followBtn').text('".UserModule::t('Unfollow')."');	
                    $('.follow-count').html(data.res);
				}
			});
		}
		
		else if(elem.hasClass('unfollow'))
		{
			$('#followBtn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/user/user/unfollow?username=".$model->username."',
                dataType: 'json',
				success: function(data){
					$('#followBtn').addClass('btn-success');
                    $('#followBtn').removeClass('unfollow');
                    $('#followBtn').addClass('follow');
					$('#followBtn').text('".UserModule::t('Follow')."');
                    $('.follow-count').html(data.res);
				}
			});
		}			
});

$('.chooser').click(function(event){
	var elem = $(this);
	
	if(!elem.hasClass('clicked'))
	{
		$('.profile-column-l-chooser').find('.clicked').removeClass('clicked');
		elem.addClass('clicked');
		
		if(elem.hasClass('activity'))
		{
			if(!elem.hasClass('already-loaded'))
			{
				$('.profile-column-l').css({'opacity':'0.5'});
				$.ajax({
					url: '".Yii::app()->request->baseUrl."/activityuser/index?username=".$model->username."&offset=0',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					dataType: 'json',
					success: function(data){
						$('.profile-column-l').css({'display':'none'});
						$('.profile-column-l').css({'opacity':'1'});
						$('.content-info-activity').html(data.res);
						$('.profile-column-l-activity').css({'display':'block'});
						elem.addClass('already-loaded');
					}
				});
			}
			else
			{
				$('.profile-column-l').css({'display':'none'});
				$('.profile-column-l-activity').css({'display':'block'});
			}
		}
		else if(elem.hasClass('info'))
		{
			$('.profile-column-l-activity').css({'display':'none'});
			$('.profile-column-l').css({'display':'block'});
		}
	}
	
});

$('.profile-column-l-activity').on('click','.more-activities',function(event){
	var elem = $(this);
	var offset = elem.attr('data-offset');
	$.ajax({
		url: '".Yii::app()->request->baseUrl."/activityuser/index?username=".$model->username."&offset='+offset,
		type: 'POST',
		data: {
			YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
		},
		dataType: 'json',
		success: function(data){
			elem.remove();
			$('.content-info-activity').append(data.res);
		},
		error: function(data){
			$('.content-info-activity').append('asd');
		}
	});

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

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true,
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array('style'=>'margin: 10px 0;'),
    'userComponentId' => 'user',
    'alerts' => array( // configurations per alert type
        // success, info, warning, error or danger
        'success' => array('block' => false, 'closeText' => '&times;'),
        'news' => array('block' => false, 'closeText' => '&times;'),
        'error' => array('block' => false, 'closeText' => '&times;')
    ),
));?>

<!--
<?php //if(Yii::app()->user->checkAccess('updateSelf', array('userid'=>$model->id)) && User::model()->findByPk(Yii::app()->user->id)->lastvisit_at == 0 && $model->newsletter == 0): ?>
<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Quer ficar por dentro das oportunidades de investimento da NextBlue? Edite suas <a href="/bnieq/user/settings" class="alert-link">configurações</a>.
</div>
<?php //endif; ?>
-->
    

<div class="profile-header-wrap">
    <div class="profile-header">	

        <div id="startup-profile-img">
            <img src="<?php echo 'http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$profile->logo->name ?>">
        </div>

        <div class="user-profile-header-info">     

            <div class="profile-name">
                <span><?php echo $model->getFullName(); ?></span>
            </div>

            <div class="user-profile-onelinepitch">
                <span><?php echo $profile->resume; ?></span>
            </div>

            <?php if (isset($profile->city)): ?>
            <div class="user-profile-location">
                <i class="icon-map-marker profile-icon"></i><a href="#"><?php if (isset($profile->city)) echo $profile->city->nome; ?></a>
            </div>
            <?php endif; ?>        

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
                    
                    <div class="founder" data-html=true>
                        <a href="#" data-toggle="modal" data-target="#modal-followers">
                            <div class="follow-count"><?php echo count($model->followers) ?></div>
                            <div class="follow-status"><?php echo UserModule::t('Followers') ?></div>
                        </a>     
                        
                        <?php $this->beginWidget(
                            'bootstrap.widgets.TbModal',
                            array('id' => 'modal-followers')
                        ); ?>
                            <div class="modal-header">
                                <a class="close" data-dismiss="modal">&times;</a>
                                <h4 class="modal-title" id="myModalLabel"><?php echo UserModule::t('Followers') ?></h4>
                            </div>

                            <div class="modal-body">
                                <?php $this->renderPartial('_followpop',array('provider'=>$model->followers, 'attr'=>'follower')) ?>
                            </div>

                            <div class="modal-footer">
                                
                                <?php $this->widget(
                                    'bootstrap.widgets.TbButton',
                                    array(
                                        'label' => 'Close',
                                        'url' => '#',
                                        'htmlOptions' => array('data-dismiss' => 'modal'),
                                    )
                                ); ?>
                            </div>

                        <?php $this->endWidget(); ?>

                    </div>
                    
                </div>

                <?php if(Yii::app()->user->checkAccess('followUser', array('userid'=>$model->id))): ?>
                <?php 
                    if(!$model->hasUserFollowing(Yii::app()->user->id))
                    {
                        $this->widget('bootstrap.widgets.TbButton', array(
                        'label'=>UserModule::t('Follow'),
                        'id'=>'followBtn', 
                        'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                        'size'=>'normal', // null, 'large', 'small' or 'mini'
                        'url'=>'',//array('follow','name'=>$model->name),
                        'htmlOptions'=>array('style'=>'width:60px; padding-top:12px; padding-bottom:12px; font-size:13px', 'class'=>'follow'),
                        )); 
                    }
                    else
                    {
                        $this->widget('bootstrap.widgets.TbButton', array(
                        'label'=>UserModule::t('Unfollow'),
                        'id'=>'followBtn', 
                        'size'=>'normal', // null, 'large', 'small' or 'mini'
                        'url'=>'',//array('unfollow','name'=>$model->name),
                        'htmlOptions'=>array('style'=>'width:60px; padding-top:12px; padding-bottom:12px; font-size:13px', 'class'=>'unfollow'),
                        )); 
                    } ?>

                
                    <?php $this->beginWidget(
                        'bootstrap.widgets.TbModal',
                        array('id' => 'modal-message')
                    ); ?>
                        <div class="modal-header">
                            <a class="close" data-dismiss="modal">&times;</a>
                            <h4><?php echo 'Enviar mensagem para ' . $model->getFullName() ?></h4>
                        </div>

                        <div class="modal-body" id="modal-message-body">
                            
                        </div>

                    <?php $this->endWidget(); ?>

                    
                    <?php if($model->hasUserFollowing(Yii::app()->user->id)){
                            
                            echo CHtml::ajaxLink(UserModule::t('Message'), 
                                array('/messages/composewithid/'.$model->id), 
                                array('update'=>'#modal-message-body'),
                                array('class' => 'btn btn-warning', 'style' => 'padding:12px 9px; margin-left: 10px; font-size:13px', 'data-toggle'=>'modal', 'data-target'=>'modal-message', 'onClick'=>'$("#modal-message").modal("toggle")'));
                            
                        }       
                        else {
                            $this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                                    'label' => UserModule::t('Message'),
                                    'htmlOptions' =>                                  
                                        array('style' => 'width:70px; padding:12px 5px; margin-left: 10px; font-size:13px', 'data-toggle' => 'tooltip', 'data-original-title' => 'Siga primeiro'),
                                )                        
                            );
                        }
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

        </div>
    </div>
    
    <div class="profile-column-l-chooser">
		<ul>
			<li class="chooser info clicked">
				<a href="javascript:void(0)"><?php echo UserModule::t('Informations');?></a>
			</li>
			<li class="chooser activity">
				<a href="javascript:void(0)"><?php echo UserModule::t('Activities');?></a>
			</li>
		</ul>
		
	</div>
</div>
	

<div class="profile-column-l">	
    
    <div class="content-wrap">
        
		<div class="content-head clicked">
            <i class="icon-briefcase profile-icon"></i> Porfolio
        </div>
		
        
		<div class="content-info">
            <?php if(count($model->startups) > 0):?>
            <div class="cards-wrap">
                <?php foreach($model->startups as $startup):  ?>
                <?php $relational_tbl=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$model->id, ':s_id'=>$startup->id)); ?>
                <?php if($relational_tbl->approved):?>
                    <?php if($relational_tbl->profile):?>
                    <div class="startup-card">
                        <div class="startup-pic" style="overflow: auto;"><?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$startup->logo0->name.'"/>', array('/startup/view', 'name'=>$startup->startupname)); ?> </div>
                        <div class="startup-name"><?php echo CHtml::link($startup->name, array('/startup/view', 'name'=>$startup->startupname)); ?></div>
                        <div class="user-position"><?php echo ($relational_tbl->title === NULL || $relational_tbl->title === '') ? UserModule::t($relational_tbl->position) :  UserModule::t($relational_tbl->title);?></div>
                    </div>
                    <?php endif;  ?>
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
            
            <?php else: ?>	
                Este usuário ainda não está relacionado a nenhuma Startup da NextBlue.
            <?php endif; ?>
		</div>
		
	</div>	
    
    
    <?php if($profile->experiences || $model->getSkillsForPrint()):?>
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
    <?php endif; ?>
	
    
    <?php if($profile->interests || $model->getSectorsForPrint()):?>
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
    <?php endif; ?>
</div>

<div class="profile-column-l-activity">

	<div class="content-wrap">

		<div class="content-head">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i><?php echo UserModule::t('Activities') ?></span>
			<span class="tip">Atividades recentes do usuário</span>
		</div>
		
		<div class="content-info">
			<div class="content-info-activity"></div>
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
            <i class="icon-circle-arrow-up profile-icon"></i> <?php echo UserModule::t('References'); ?>
        </div>
		
		<div class="content-info" style="padding: 0;">            
            <div class="content-info-unit">
                <div class="follow-block">
                    <a href="#" data-toggle="modal" data-target="#modal-following">
                        <?php echo UserModule::t('Following') ?>
                    </a>     

                    <?php $this->beginWidget(
                        'bootstrap.widgets.TbModal',
                        array('id' => 'modal-following')
                    ); ?>
                        <div class="modal-header">
                            <a class="close" data-dismiss="modal">&times;</a>
                            <h4 class="modal-title" id="myModalLabel"><?php echo UserModule::t('Following') ?></h4>
                        </div>

                        <div class="modal-body">
                            <?php $this->renderPartial('_followpop',array('provider'=>$model->following, 'attr'=>'followed')) ?>
                        </div>

                        <div class="modal-footer">

                            <?php $this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                                    'label' => 'Close',
                                    'url' => '#',
                                    'htmlOptions' => array('data-dismiss' => 'modal'),
                                )
                            ); ?>
                        </div>

                    <?php $this->endWidget(); ?>

                </div>
                <div class="follow-block">
                    <a href="#" data-toggle="modal" data-target="#modal-startups-follow">
                        <?php echo UserModule::t('Startups') ?>
                    </a> 
                    
                    <?php $this->beginWidget(
                        'bootstrap.widgets.TbModal',
                        array('id' => 'modal-startups-follow')
                    ); ?>
                        <div class="modal-header">
                            <a class="close" data-dismiss="modal">&times;</a>
                            <h4 class="modal-title" id="myModalLabel"><?php echo UserModule::t('Startups followed') ?></h4>
                        </div>

                        <div class="modal-body">
                            <?php $this->renderPartial('_sfollowpop',array('provider'=>$model->startupFollows)) ?>
                        </div>

                        <div class="modal-footer">

                            <?php $this->widget(
                                'bootstrap.widgets.TbButton',
                                array(
                                    'label' => 'Close',
                                    'url' => '#',
                                    'htmlOptions' => array('data-dismiss' => 'modal'),
                                )
                            ); ?>
                        </div>

                    <?php $this->endWidget(); ?>
                
                </div>
                <div class="follow-block">
                    <a href="#" data-toggle="modal" data-target="#modal-followers">
                        <?php echo UserModule::t('Followers') ?>
                    </a>
                </div>                		 
            </div>            
		</div>
    </div>
    
    <?php if(!$model->isReallyYou()): ?> 
        <span class="edit-btn-user">
     
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>UserModule::t('Report'),
                'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'normal', // null, 'large', 'small' or 'mini'
                'htmlOptions'=>array('data-toggle'=>'modal', 'data-target'=>'#report-modal'),
            )); 
            ?>

        </span>
    
        <?php $this->beginWidget('bootstrap.widgets.TbModal',
            array('id' => 'report-modal')
        ); ?>

            <div class="modal-header">
                <a class="close" data-dismiss="modal">&times;</a>
                <h4>Report <?php echo $model->getfullname() ?></h4>
            </div>

            <div class="modal-body">
                <?php 
                $rep = new Report;
                
                $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                    'id'=>'report-form',
                    'type'=>'horizontal',
                    'action'=>Yii::app()->request->baseUrl.'/user/profile/report',
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                    ),
                    'enableClientValidation'=>true,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data',
                    ),
                    'inlineErrors'=>false,
                )); 
                                                
                ?>
                
                <div class="group-wrap" style="border-bottom:1px dashed #aaa; padding-bottom:30px; overflow:auto; margin-bottom:40px;">
                    <div style="float:left;">
                    <?php echo $form->textAreaRow($rep,'text',array('labelOptions' => array('label' => 'Acusação', 'class'=>'custom-label'), 'class'=>'span3','maxlength'=>100)); ?>
                    <?php echo $form->error($rep,'text', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>
                    <?php echo $form->hiddenField($rep,'target_id',array('value' => $model->id)); ?>
                    <div class="tip" style="margin-left:180px; margin-top:5px; color:#646464; width:300px; font-style:italic;">
                    O que esse usuário fez? Seja específico.
                    </div>
                    </div>
                </div>	
                
            </div>

            <div class="modal-footer">
                <?php $this->widget('bootstrap.widgets.TbButton',
                    array(
                        'buttonType' => 'submit',
                        'type'=>'primary',
                        'label' => 'Report',
                        //'htmlOptions' => array('data-dismiss' => 'modal'),
                    )
                ); ?>
            </div>
            <?php $this->endWidget(); ?>


        <?php $this->endWidget(); ?>

    <?php endif; ?>     


		
    
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

        
        
        