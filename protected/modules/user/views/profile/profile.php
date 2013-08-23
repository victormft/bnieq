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
?>

<h1>
<?php
    $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'firstname',
        'url'       => array('update'),  //url for submit data          
        'placement' => 'bottom',
        'apply'  => ((UserModule::isAdmin() || $model->id == Yii::app()->user->id)	? true : false),
     ));
     echo ' ';
     $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'lastname',
        'url'       => array('update'),             
        'placement' => 'right',
        'apply'  => ((UserModule::isAdmin() || $model->id == Yii::app()->user->id)	? true : false),
     ));
?>
</h1>

<?php
    $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'textarea',
        'model'     => $profile,
        'attribute' => 'resume',
        'url'       => array('update'),  
        'placement' => 'right',
        'apply'  => ((UserModule::isAdmin() || $model->id == Yii::app()->user->id)	? true : false),
     ));
?>

<?php echo $model->getRoleNames(); ?>


<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Edit',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
	'url'=>array('edit_basic', 'id'=>$model->id),
)); ?>

<div class="socials">    
    <a href=<?php echo $profile->facebook; ?>> <img src=<?php echo Yii::app()->request->baseUrl.'/images/facebook.png>';?> </a>
    <a href=<?php echo $profile->linkedin; ?>> <img src=<?php echo Yii::app()->request->baseUrl.'/images/linkedin.png>';?> </a>
    <a href=<?php echo $profile->twitter; ?>> <img src=<?php echo Yii::app()->request->baseUrl.'/images/twitter.png>';?> </a>
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
            'apply'  => ((UserModule::isAdmin() || $model->id == Yii::app()->user->id)	? true : false),
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
            'apply'  => ((UserModule::isAdmin() || $model->id == Yii::app()->user->id)	? true : false),
         )); ?> 
    </p>
</div>

<h3>Experiences</h3>
<div class="">
    <?php echo '<b>Working experiences: </b>'; ?>
    
    <?php $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'textarea',
        'model'     => $profile,
        'attribute' => 'experiences',
        'url'       => array('update'),  
        'placement' => 'right',
        'apply'  => ((UserModule::isAdmin() || $model->id == Yii::app()->user->id)	? true : false),
     )); ?>    
</div>

<div class="">
    <?php echo '<b>Skills:</b> (definir skills padroes)'; ?>
    
</div>

<h3>Interests</h3>
<div class="">
    <?php echo '<b>Interests: </b>'; ?>    
    <?php $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'textarea',
        'model'     => $profile,
        'attribute' => 'interests',
        'url'       => array('update'),  
        'placement' => 'right',
        'apply'  => ((UserModule::isAdmin() || $model->id == Yii::app()->user->id)	? true : false),
     )); ?>    
</div>

<div class="">
    <?php echo '<b>Sectors of interest:</b> (definir skills padroes)'; ?>
    
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
            'apply'  => ((UserModule::isAdmin() || $model->id == Yii::app()->user->id)	? true : false),
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
            'apply'  => ((UserModule::isAdmin() || $model->id == Yii::app()->user->id)	? true : false),
         )); ?>  
    </p>
</div>

