<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome/css/font-awesome.min.css" />

	

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>   

    
<div class="navbar navbar-inverse">
    <div class="navbar-inner" style="border-radius: 0">
        <form class="navbar-search pull-left" style="margin-left: 80px">
            <input type="text" class="search-query" placeholder="Search">
        </form>
        <ul class="nav pull-right" style="margin-right: 80px">
            <li><a href= <?php echo Yii::app()->homeUrl; ?> >Home</a></li>
            <li><a href= <?php echo Yii::app()->homeUrl . '/site/contact'?> >Contact us</a></li>
            <?php if(Yii::app()->user->isGuest):?>
                <li><a href= <?php echo Yii::app()->homeUrl . '/user/login'?> >Login</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl . '/user/registration'?> >Register</a></li>
            <?php else: ?>
                <li><a href= <?php echo Yii::app()->homeUrl . '/user/profile?username=' . Yii::app()->user->username ?> >Profile</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl . '/user/logout' ?> >Logout</a></li>
            <?php endif?>
        </ul>
    </div>
</div>
    
<div class="container" id="page">    
        
    <div class="navbar">
        <div class="navbar-inner" style="border-radius: 0; margin: 0 auto; display: table;">
            <ul class="nav" style="">
                <li><a href= <?php echo Yii::app()->homeUrl . '/startup' ?> >Startups</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl . '/user/user' ?> >Community</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl; ?> >Invest</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl; ?> >Get investment</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl; ?> >How it works</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl . '/site/page?view=about' ?> >About us</a></li>              
            </ul>
        </div>
    </div>

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
