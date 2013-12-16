<?php
$this->layout='column1';
?>


<div class="sub-header-bg"></div>
<h1 class="create-title" style="margin-top:25px;"><?php echo UserModule::t('Activities'); ?></h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:60px;"><?php echo UserModule::t('Your most recent activities.'); ?></div>

<div class="row">
    <div class="spacing-1"></div>

    <?php $this->widget('bootstrap.widgets.TbMenu', array(
        'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
        'id'=>'activity-menu',
        'stacked'=>true, // whether this is a stacked menu
        'items'=>array(
            array('label'=>UserModule::t('Following'), 'url'=>'activity', 'active'=>($active==='index') ? true:false),
            array('label'=>UserModule::t('Public'), 'url'=>'public', 'active'=>($active==='public') ? true:false),
        ),
    )); ?>
    
    <div class="activities-wrap">
        <?php echo $html; ?>
    </div>
    

    
</div>


