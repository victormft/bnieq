<?php /* @var $this Controller */ ?>
<?php 

Yii::app()->clientScript->registerScript('main-script',
"

	$('.about').click(function(event) {
		$('#about').slideDown();	
	});
	
	$('.how').click(function(event) {
		$('#how').slideDown();
	});
	
	$('.close-about').click(function(event) {
		$('#about').slideUp();
	});
	
	$('.close-how').click(function(event) {
		$('#how').slideUp();
	});
	
	
");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome/css/font-awesome.min.css" />	

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

</head>

<body>   
    

<div class="navbar navbar-inverse">
    <div class="navbar-inner" style="border-radius: 0">
        <a class="brand" style="margin-left: 80px" href=<?php echo Yii::app()->homeUrl; ?>>NEXTBLUE</a>
        <form class="navbar-search pull-left" style="margin-left: 80px">
            <input type="text" class="search-query" placeholder="Search">
        </form>
        <ul class="nav pull-right" style="margin-right: 80px">
            <li class="home"><a href= <?php echo Yii::app()->homeUrl; ?> >Home</a></li>            
            <li><a href= <?php echo Yii::app()->homeUrl . '/site/contact'?> >Contact us</a></li>
            <?php if(Yii::app()->user->isGuest):?>
                <li><a href= <?php echo Yii::app()->homeUrl . '/user/login'?> >Login</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl . '/user/registration'?> >Register</a></li>
            <?php else: ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Account <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href= <?php echo Yii::app()->homeUrl . '/user/profile' ?> >Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li class="nav-header">NAV HEADER</li>
                        <li>
                            <a href=<?php echo Yii::app()->homeUrl . '/user/settings/general' ?>>Settings</a>
                        </li>
                    </ul>                    
                </li>
                <li><a href= <?php echo Yii::app()->homeUrl . '/mailbox' ?> >Messages</a></li>
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
                <li><a class="how" href= "#" >How it works</a></li>
                <li><a class="about" href= "#" >About us</a></li>             
                <?php if(UserModule::isAdmin()): ?>
                    <li><a href= <?php echo Yii::app()->homeUrl . '/user/admin' ?> >ADMIN PANEL</a></li> 
                <?php endif; ?>
            </ul>
        </div>
    </div>
	
	<div id="how">
		How it Works - Em Construção
		<div class="close-how" style="display:inline;"> <a href="#">x</a></div>
	</div>
	
	<div id="about">
		About - Em Construção
		<div class="close-about" style="display:inline;"> <a href="#">x</a></div>
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
