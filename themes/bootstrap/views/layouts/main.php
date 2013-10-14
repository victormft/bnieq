<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles2.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome/css/font-awesome.min.css" />	

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>   
    
<?php if(!Yii::app()->user->isGuest) $user = User::model()->findbyPk(Yii::app()->user->id); ?>    
    
<div class="navbar" id="main-nav">
    <div class="nav-inner" style="border-radius: 0">
        <a class="brand" href=<?php echo Yii::app()->homeUrl; ?>>NEXTBLUE</a>
        <form class="navbar-search pull-left">
            <input type="text" class="search-query" placeholder="Buscar...">
        </form>
        <ul class="nav primary">
            <li><a href= <?php echo Yii::app()->homeUrl . '/startup' ?> ><i class="icon-suitcase" style="display:block; margin:5px auto;"></i>Startups</a></li>
			<li><a href= <?php echo Yii::app()->homeUrl . '/user' ?> ><i class="icon-group" style="display:block; margin:5px auto;"></i>Usuários</a></li>       
            <li><a href= <?php echo Yii::app()->homeUrl; ?> ><i class="icon-question-sign" style="display:block; margin:5px auto; font-size:17px;"></i>Como Funciona</a></li>   
			<li><a href= <?php echo Yii::app()->homeUrl; ?> ><i class="icon-info-sign" style="display:block; margin:5px auto; font-size:17px;"></i>Sobre Nós</a></li>
			<li><a href= <?php echo Yii::app()->homeUrl; ?> ><i class="icon-comments" style="display:block; margin:5px auto; font-size:17px;"></i>Nosso Blog </a></li>
        </ul>
		
		<ul class="nav pull-right secondary">
			<?php if(Yii::app()->user->isGuest):?>
                <li><a style="display:inline-block; padding-right:7px;" href= <?php echo Yii::app()->homeUrl . '/user/login'?> ><i class="icon-lock" style="display:inline; margin-right:10px; font-size:15px; line-height:20px;"></i>Login</a></li>
                <li><a style="display:inline-block; padding-left:7px;" href= <?php echo Yii::app()->homeUrl . '/user/login'?> ><i class="icon-user" style="display:inline; margin-right:10px; font-size:15px; line-height:20px;"></i>Register</a></li>
            <?php else: ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $user->profile->firstname; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href= <?php echo Yii::app()->homeUrl . '/user/profile' ?> >Profile</a>
                        </li>
						<li><a href= <?php echo Yii::app()->homeUrl . '/messages/inbox' ?> >Messages <?php echo (Message::model()->getCountUnreaded(Yii::app()->user->getId()) ?
                        ' (' . Message::model()->getCountUnreaded(Yii::app()->user->getId()) . ')' : '') ?></a>
						</li>
                        <li class="divider"></li>
                        <li>
                            <a href=<?php echo Yii::app()->homeUrl . '/user/settings/general' ?>>Settings</a>
                        </li>
                    </ul>                    
                </li>
                <li><a style="display:inline-block;" href= <?php echo Yii::app()->homeUrl . '/user/logout' ?> ><i class="icon-power-off" style="display:inline; margin-right:10px; font-size:15px; line-height:20px;"></i>Logout</a></li>
            <?php endif?>
		</ul>
    </div>
</div>
    
<div class="container" id="page">    
    <!--    
    <div class="navbar">
        <div class="navbar-inner" style="border-radius: 0; margin: 0 auto; display: table;">
            <ul class="nav" style="">
                <li><a href= <?php echo Yii::app()->homeUrl . '/startup' ?> >Startups</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl . '/user/user' ?> >Community</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl; ?> >Invest</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl; ?> >Get investment</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl; ?> >How it works</a></li>
                <li><a href= <?php echo Yii::app()->homeUrl . '/site/page?view=about' ?> >About us</a></li>             
                <?php if(UserModule::isAdmin()): ?>
                    <li><a href= <?php echo Yii::app()->homeUrl . '/user/admin' ?> >ADMIN PANEL</a></li> 
                <?php endif; ?>
            </ul>
        </div>
    </div>
	-->
<!--
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs 
	<?php endif?>
-->
	<?php echo $content; ?>

	<div class="clear"></div>

	
	<!--
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by BNI Tech.<br/>
		All Rights Reserved.<br/>
	</div>--><!-- footer -->
	
</div><!-- page -->

<div id="new-footer">
	<div class="footer-content">
		<div class="col">
			<span class="col-head">Startups</span>
			<ul>
				<li>
					<a>Art</a>
				</li>
				<li>
					<a>Creative Economy</a>
				</li>
				<li>
					<a>Education</a>
				</li>
				<li>
					<a>Entertainment</a>
				</li>
				<li>
					<a>Environment</a>
				</li>
				<li>
					<a>Financial</a>
				</li>
				<li>
					<a>Internet Business</a>
				</li>
				<li>
					<a>Technology</a>
				</li>		 
			</ul>
		</div>
		<div class="col fol">
			<span class="col-head">Usuários</span>
			<ul>
				<li>
					<a>Populares</a>
				</li>
				<li>
					<a>Recentes</a>
				</li>
				<li>
					<a>Investidores</a>
				</li>
				<li>
					<a>Empreendedores</a>
				</li>
			</ul>
		</div>
		<div class="col fol">
			<span class="col-head">Sobre</span>
			<ul>
				<li>
					<a>Sobre Nós</a>
				</li>
				<li>
					<a>Como Funciona</a>
				</li>
				<li>
					<a>Ajuda</a>
				</li>
			</ul>
		</div>
		<div class="col fol">
			<span class="col-head">Navegue</span>
			<ul>
				<li>
					<a>Startups</a>
				</li>
				<li>
					<a>Usuários</a>
				</li>
				<li>
					<a>Pitches</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="footer-social">
		<ul>
			<li class="facebook">
				<a>face</a>
			</li>
			<li class="linkedin">
				<a></a>
			</li>
			<li class="twitter">
				<a></a>
			</li>
			<li class="google-plus">
				<a></a>
			</li>
		</ul>
		<div class="terms">
			<a>Terms of Service</a> |
			<a>License</a> |
			<a>Contact Us</a>
			<div>Copyright © 2013 NextBlue</div>
		</div>
	</div>
</div>
</body>
</html>
