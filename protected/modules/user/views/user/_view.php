
<div class="view-list">

    <div class="startup-view-img">
        <?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$data->logo->name.'" />', array('/' . $data->user->username)); ?>
    </div>
    
    <div class="view-list-text">
    
        <?php echo CHtml::link(CHtml::encode($data->user->getFullName()),array('/' . $data->user->username), array('class'=>'startup-view-name'));?>

        <div class="profile-view-pitch" >
            <?php echo CHtml::encode($data->resume); ?>
        </div>
        <?php if (isset($data->city)): ?>
        <div class="startup-view-location">
			<i class="icon-map-marker"></i><a href="<?php echo Yii::app()->baseUrl.'/user?g=&c='.$data->city->id; ?>"><?php echo $data->city->nome; ?></a> 		
		</div>
        <?php endif; ?>

        <div class="profile-view-role">	
            <?php echo $data->user->getRolesForPrint() ?>
        </div>
    </div>
       
        
    <?php if(Yii::app()->user->checkAccess('followUser', array('userid'=>$data->user_id))): ?>
    
    <div class="follow-count" data-name="<?php echo $data->user->username; ?>"><?php echo count($data->user->followers); ?></div>   
    
    <span class="follow-btn">    
        <?php 
        if(!$data->user->hasUserFollowing(Yii::app()->user->id))
        {
            $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Follow',
            'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'mini', // null, 'large', 'small' or 'mini'
            'url'=>'',//array('follow','name'=>$model->name),
            'htmlOptions'=>array('class'=>'btn-follow follow-press'),
            )); 
        }
        else
        {
            $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Unfollow',
            'size'=>'mini', // null, 'large', 'small' or 'mini'
            'url'=>'',//array('unfollow','name'=>$model->name),
            'htmlOptions'=>array('class'=>'btn-follow follow-press'),
            )); 
        }
        ?>        
    </span>
    
    <?php endif ?>
    
</div>

