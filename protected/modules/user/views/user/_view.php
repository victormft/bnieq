<?php if($data->user->id !== Yii::app()->user->id): ?>

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
    
</div>

<?php endif ?>