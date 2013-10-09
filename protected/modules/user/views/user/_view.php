<?php if($data->user->id !== Yii::app()->user->id): ?>

<?php
Yii::app()->clientScript->registerScript('follow-'.$data->user->username,
"
$('#follow-".$data->user->username."').click(function(event) {

		if($('#follow-".$data->user->username."').text()==='Follow')
		{	
			$('#follow-".$data->user->username."').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');			
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/user/user/follow?username=".$data->user->username."',
				dataType: 'json',
				success: function(data){
					$('#follow-".$data->user->username."').removeClass('btn-success');
					$('#follow-".$data->user->username."').text('Unfollow');	
                    $('#follow-count-".$data->user->username."').html(data.res);
				}
			});
		}
		
		else if($('#follow-".$data->user->username."').text()==='Unfollow')
		{
			$('#follow-".$data->user->username."').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
			
			$.ajax({
				url: '".Yii::app()->request->baseUrl."/user/user/unfollow?username=".$data->user->username."',
                dataType: 'json',
				success: function(data){
					$('#follow-".$data->user->username."').addClass('btn-success');
					$('#follow-".$data->user->username."').text('Follow');
                    $('#follow-count-".$data->user->username."').html(data.res);
				}
			});
		}			
});

");

?>

<div class="view-list">

    <?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$data->logo->name.'" id="Startup-list-img"/>', array('/user/profile', 'username'=>$data->user->username)); ?>
    
    <div class="view-list-text">
    
        <?php echo CHtml::link(CHtml::encode($data->user->getFullName()),array('/user/profile','username'=>$data->user->username), array('class'=>'startup-view-name'));?>

        <div class="profile-view-pitch" >
            <?php echo CHtml::encode($data->resume); ?>
        </div>

        <div class="profile-view-role">	
            <?php echo $data->user->getRolesForPrint() ?>
        </div>
    </div>
       
    <div class="follow-count" id="follow-count-<?php echo $data->user->username ?>"><?php echo count($data->user->followers); ?></div>   
    
    <span class="follow-btn">    
        <?php 
        if(!$data->user->hasUserFollowing(Yii::app()->user->id))
        {
            $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Follow',
            'id'=>'follow-'.$data->user->username,
            'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'mini', // null, 'large', 'small' or 'mini'
            'url'=>'',//array('follow','name'=>$model->name),
            //'htmlOptions'=>array('style'=>'width:50px; padding-top:12px; padding-bottom:12px;'),
            )); 
        }
        else
        {
            $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Unfollow',
            'id'=>'follow-'.$data->user->username,
            'size'=>'mini', // null, 'large', 'small' or 'mini'
            'url'=>'',//array('unfollow','name'=>$model->name),
            //'htmlOptions'=>array('style'=>'width:50px; padding-top:12px; padding-bottom:12px;'),
            )); 
        }
        ?>        
    </span>
    
</div>

<?php endif ?>