


<div class="items" style="text-align: left;">
    <?php foreach($provider as $arr):  ?>
    <div class="view-list">

        <?php echo CHtml::link('<div class="startup-view-img" style="background-image:url(http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$arr->profile->logo->name.'); background-size:cover; background-position: 50% 50%;"></div>', array('/'.CHtml::encode($arr->username)));?>


        <div class="view-list-text">    
            <?php echo CHtml::link(CHtml::encode($arr->getFullName()),array('/' . $arr->username), array('class'=>'startup-view-name'));?>

            <div class="profile-view-pitch" >
                <?php echo CHtml::encode($arr->profile->resume); ?>
            </div>
        </div>      

        <?php if(Yii::app()->user->checkAccess('followUser', array('userid'=>$arr->id))): ?>

            <span class="follow-btn" data-name="<?php echo $arr->username; ?>">    
                <?php 
                if(!$arr->hasUserFollowing(Yii::app()->user->id))
                {
                    $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>UserModule::t('Follow'),
                    'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size'=>'mini', // null, 'large', 'small' or 'mini'
                    'url'=>'',//array('follow','name'=>$model->name),
                    'htmlOptions'=>array('class'=>'btn-follow follow-press'),
                    )); 
                }
                else
                {
                    $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>UserModule::t('Unfollow'),
                    'size'=>'mini', // null, 'large', 'small' or 'mini'
                    'url'=>'',//array('unfollow','name'=>$model->name),
                    'htmlOptions'=>array('class'=>'btn-unfollow follow-press'),
                    )); 
                }
                ?>        
            </span>


        <?php endif ?>

    </div>
    <?php endforeach;  ?>
</div>