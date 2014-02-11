<!--
<div class="cards-wrap">
    <?php foreach($provider as $arr):  ?>
    <div class="startup-card">
        <div class="startup-pic" style="overflow: auto;"><?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$arr->logo0->name.'"/>', array('startup/view', 'name'=>$arr->startupname)); ?> </div>
        <div class="startup-name"><?php echo CHtml::link(CHtml::encode($arr->name), array('startup/view','name'=>$arr->startupname)); ?></div>
    </div>
    <?php endforeach;  ?>
</div>
-->

<div class="items" style="text-align: left;">
    
    <?php foreach($provider as $arr):  ?>
    <div class="view-list">

        <?php echo CHtml::link('<div class="startup-view-img" style="background-image:url('.Yii::app()->request->baseUrl.'/images/'.$arr->logo0->name.'); background-size:cover; background-position: 50% 50%;"></div>', array('/'.CHtml::encode($arr->startupname)));?>

        <div class="view-list-text" style="overflow:hidden; max-width:280px;">

            <?php echo CHtml::link(CHtml::encode($arr->name),array('/'.CHtml::encode($arr->startupname)), array('class'=>'startup-view-name'));?>

            <div class="startup-view-pitch">
                <?php echo CHtml::encode($arr->one_line_pitch); ?>
            </div>


        </div>
  

        <?php if(!Yii::App()->user->isGuest): ?>	
            <span class="follow-btn" data-name="<?php echo CHtml::encode($arr->startupname); ?>">    
                <?php 
                if(!$arr->hasUserFollowing(Yii::app()->user->id))
                {
                    $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>UserModule::t('Follow'),
                    'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size'=>'mini', // null, 'large', 'small' or 'mini'
                    'url'=>'',//array('follow','name'=>$model->name),
                    'htmlOptions'=>array('class'=>'btn-follow follow-press start',),
                    )); 
                }
                else
                {
                    $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>UserModule::t('Unfollow'),
                    'size'=>'mini', // null, 'large', 'small' or 'mini'
                    'url'=>'',//array('unfollow','name'=>$model->name),
                    'htmlOptions'=>array('class'=>'btn-unfollow follow-press start'),
                    )); 
                }
                ?>        
            </span>
        <?php endif;?>

    </div>
    <?php endforeach;  ?>
    
</div>