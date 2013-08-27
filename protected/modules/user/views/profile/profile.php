<?php 

$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);

$apply = true; //apply Editable fields or not
if (!UserModule::isAdmin() && $model->id !== Yii::app()->user->id) 
{
    $apply = false;    
    $profile->birthday=date('d/m/Y', strtotime(str_replace("-", "", $profile->birthday)));    
}

?>


<h1>
<?php
    $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'firstname',
        'url'       => array('update'),  //url for submit data          
        'placement' => 'bottom',
        'apply'     => $apply,
     ));
     echo ' ';
     $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'lastname',
        'url'       => array('update'),             
        'placement' => 'right',
        'apply'     => $apply,
     ));
?>
</h1>

<div class="btn_follow" style="float:right;">
 <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Follow',
        'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'=>'large', // null, 'large', 'small' or 'mini'
        'url'=>array('follow', 'id'=>$model->id),
    )); ?>
</div>

<p><?php
    $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'textarea',
        'model'     => $profile,
        'attribute' => 'resume',
        'url'       => array('update'),  
        'placement' => 'right',
        'apply'     => $apply,
     ));
?></p>

<?php $this->renderPartial('_roles', array('model'=>$model, 'profile'=>$profile)); ?>

<?php $this->widget('bootstrap.widgets.TbBox', array(
    'title' => 'PORTFOLIO',
    'headerIcon' => 'icon-home',
    'content' => 'Portfolio will come here.', // $this->renderPartial('_view')
    'htmlOptions' => array('style'=>'margin-top:30px; padding-right:300px'),
)); ?>

<h3>What I do</h3>
<div class="">
    <p> <?php echo '<b>Working experiences: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'textarea',
            'model'     => $profile,
            'attribute' => 'experiences',
            'url'       => array('update'),  
            'placement' => 'right',
            'apply'  => $apply,
         )); ?>    
    </p>
     
    <div class="">
        <?php echo '<b>Skills:</b> (VER COMO VAI SER)'; ?>
        
    </div>
</div>

<h3>What I'm looking for</h3>
<div class="interests">
    <p> <?php echo '<b>Interests: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'textarea',
            'model'     => $profile,
            'attribute' => 'interests',
            'url'       => array('update'),  
            'placement' => 'right',
            'apply'  => $apply,
         )); ?>    
    </p>
    
    <div class="sectors_wrap">
        <?php $this->renderPartial('_sectors', array('model'=>$model, 'profile'=>$profile)); ?>
    </div>
    
</div>




<h3>Personal</h3>
<div class="">
    <p> <?php echo '<b>Birthday: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'date',
            'model'     => $profile,
            'attribute' => 'birthday',
            'url'       => array('update'),  
            'placement' => 'right',
            'format'      => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
            'viewformat'  => 'dd/mm/yyyy', //format in which date is displayed
            'apply'      => $apply,
         )); ?>  
    </p>
    
    <p> <?php echo '<b>Gender: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'select',
            'model'     => $profile,
            'attribute' => 'gender',
            'url'       => array('update'),  
            'source'    => $profile->getGenderOptions(), 
            'placement' => 'right',
            'apply'     => $apply,
         )); ?> 
    </p>
    
    <p>Location</p>
</div>

<h3>Contacts</h3>
<div class="">
    <p><?php echo '<b>Email: </b>' . $model->email; ?></p>
    
    <p>
        <?php echo '<b>Telephone: </b>'?>
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'textarea',
            'model'     => $profile,
            'attribute' => 'telephone',
            'url'       => array('update'),  
            'placement' => 'right',
            'apply'  => $apply,
         )); ?>  
    </p>
    
    <p>
        <?php echo '<b>Skype: </b>'?>
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'textarea',
            'model'     => $profile,
            'attribute' => 'skype',
            'url'       => array('update'),  
            'placement' => 'right',
            'apply'  => $apply,
         )); ?>  
    </p>
</div>

