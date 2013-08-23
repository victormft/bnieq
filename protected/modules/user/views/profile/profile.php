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
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?>

<h1><?php echo $profile->firstname.' '.$profile->lastname; ?></h1>


<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Edit',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
	'url'=>array('edit_basic'),
)); ?>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>

<?php
    $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'text',
        'model'     => $profile,
        'attribute' => 'firstname',
        'url'       => array('update'),  //url for submit data
        'placement' => 'right',
     ));
?>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$profile,
	'attributes'=>array(
		'firstname',
		'lastname',
		'profile_picture',
		'resume',
		'address',
		array(               
            'label'=>'Facebook',
            'type'=>'raw',
            'value'=>CHtml::link(CHtml::encode($profile->facebook), $profile->facebook),
        ),
		array(               
            'label'=>'Linkedin',
            'type'=>'raw',
            'value'=>CHtml::link(CHtml::encode($profile->linkedin), $profile->linkedin),
        ),
		array(               
            'label'=>'Twitter',
            'type'=>'raw',
            'value'=>CHtml::link(CHtml::encode($profile->twitter), $profile->twitter),
        ),
        array(               
            'label'=>'Roles',
            'type'=>'raw',
            'value'=> $model->getRoleNames(),
        ),
	),
)); ?>


<h3>About</h3>

<!--<table class="dataGrid">
	<tr>
		<th class="label"><?php echo CHtml::encode(UserModule::t('Name')); ?></th>
	    <td><?php echo CHtml::encode($profile->firstname . ' ' . $profile->lastname); ?></td>
	</tr>		
	<tr>
		<th class="label"><?php echo CHtml::encode(UserModule::t('Roles')); ?></th>		
	    <td>
			<?php
			foreach($model->roles as $role) {		
			?>
			<?php echo $role->name . ' -'; ?>
			<?php }	?>
		</td>
	</tr>		
	<tr>
		<th class="label"><a href=<?php echo $profile->facebook;?>> <img src=<?php echo Yii::app()->request->baseUrl.'/images/follow_facebook_gray.png>';?> </a></th>
	</tr>	
</table>-->
