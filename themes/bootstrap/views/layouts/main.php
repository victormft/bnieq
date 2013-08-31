<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
				array('label'=>'Startup', 'url'=>array('/startup/index')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
                array('label'=>'Startups', 'url'=>array('/site/index')),
				array('label'=>'Community', 'url'=>array('/user')),
				array('label'=>'Invest', 'url'=>array('#')),
				array('label'=>'Get Investment', 'url'=>array('/site/page', 'view'=>'getinvestment')),
				array('label'=>'How it works', 'url'=>array('/site/page', 'view'=>'howitworks')),
				array('label'=>'About us', 'url'=>array('/site/page', 'view'=>'about')),
				//array('label'=>'Home', 'url'=>array('/site/index')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				//
				//yii-user
				array('url'=>Yii::app()->getModule('user')->loginUrl, 'label'=>Yii::app()->getModule('user')->t("Login"), 'visible'=>Yii::app()->user->isGuest),
				array('url'=>Yii::app()->getModule('user')->registrationUrl, 'label'=>Yii::app()->getModule('user')->t("Register"), 'visible'=>Yii::app()->user->isGuest),
				array('url'=>array('/user/profile', 'id'=>Yii::app()->user->id), 'label'=>Yii::app()->getModule('user')->t("Profile"), 'visible'=>!Yii::app()->user->isGuest),
				array('url'=>Yii::app()->getModule('user')->logoutUrl, 'label'=>Yii::app()->getModule('user')->t("Logout").' ('.Yii::app()->user->name.')', 'visible'=>!Yii::app()->user->isGuest),
            ),
        ),
    ),
)); ?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by BNI Tech.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
