<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/font-awesome/css/font-awesome.min.css" />	

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles2.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles3.css" />
	

</head>

<body>   

<?php 

Yii::app()->clientScript->registerScript('main',
"

$('.search').click(function(event){
	
	$(this).animate({opacity: 0},250, function(){ 
		$(this).hide('fast');
	});
	
	$('.secondary').animate({opacity: 0}, 250, function(){ 
		$(this).hide('fast');
		$('.navbar-search').show('fast', function(){
			$(this).animate({opacity: 1}, 250);
		});
	});
					
					
					
});

$('.remove-search').click(function(event){
	
	$('.navbar-search').animate({opacity: 0},250, function(){ 
		$(this).hide('fast');
		
		$('.search').show('fast', function(){ 
			$(this).animate({opacity: 1}, 250);
		});
		
		$('.secondary').show('fast', function(){ 
			$(this).animate({opacity: 1}, 250);
		});
	
	});
						
});


");

?>
	
<?php if(!Yii::app()->user->isGuest) $user = User::model()->findbyPk(Yii::app()->user->id); ?>    
    
<div class="navbar" id="main-nav">
    <div class="nav-inner" style="border-radius: 0">
        
		<a class="brand" href=<?php echo Yii::app()->homeUrl; ?>>NEXTBLUE</a>
     
        <ul class="nav primary">
            <li><a href= <?php echo Yii::app()->homeUrl . '/startup' ?> ><i class="icon-suitcase" style="display:block; margin:5px auto;"></i>Startups</a></li>
			<li><a href= <?php echo Yii::app()->homeUrl . '/user' ?> ><i class="icon-group" style="display:block; margin:5px auto;"></i><?php echo UserModule::t("Users") ?></a></li>       
            <li><a href= <?php echo Yii::app()->homeUrl; ?> ><i class="icon-question-sign" style="display:block; margin:5px auto; font-size:17px;"></i><?php echo UserModule::t("Understand") ?></a></li>   
			<li><a href= <?php echo Yii::app()->homeUrl; ?> ><i class="icon-info-sign" style="display:block; margin:5px auto; font-size:17px;"></i><?php echo UserModule::t("About Us") ?></a></li>
			<li><a href= "http://euanjo.com.br/dep" ><i class="icon-comments" style="display:block; margin:5px auto; font-size:17px;"></i><?php echo UserModule::t("Our Blog") ?></a></li>
			<li><a href= <?php echo Yii::app()->homeUrl; ?> ><i class="icon-money" style="display:block; margin:5px auto; font-size:15px;"></i><?php echo UserModule::t("Invest") ?></a></li>
			<li class="search"><a href="javascript:void(0);" style="border:none; padding:20px 5px 20px 25px;"><i class="icon-search" style="font-size:24px;"></i><span style="font-size:18px; margin-left:10px; line-height:18px;">Procurar</span></a></li>
        </ul>
		
		
		<form class="navbar-search pull-left" style="display:none; opacity:0;">
            <input type="text" class="search-query" id="main_search" placeholder="Buscar...">
			<a href="javascript:void(0);" style="margin-top: 5px; text-decoration:none;"><i class="icon-remove-sign remove-search" style="color:#333; line-height:20px;"></i></a>
			<div class="team-loading" style="display:inline;"></div>
        </form>
	

	
		
		
		
		
		<ul class="nav pull-right secondary">
			<?php if(Yii::app()->user->isGuest):?>
                <li><a style="display:inline-block; padding-right:7px;" href= <?php echo Yii::app()->homeUrl . '/user/login'?> ><i class="icon-lock" style="display:inline; margin-right:10px; font-size:15px; line-height:20px;"></i>Login</a></li>
                <li><a style="display:inline-block; padding-left:7px;" href= <?php echo Yii::app()->homeUrl . '/user/login'?> ><i class="icon-user" style="display:inline; margin-right:10px; font-size:15px; line-height:20px;"></i><?php echo UserModule::t("Register") ?></a></li>
            <?php else: ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $user->profile->firstname; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="name-hover">
                            <a href= <?php echo Yii::app()->homeUrl . '/' . Yii::app()->user->getUsername() ?> ><i class="icon-user" style="margin:0 6px 0 0;"></i><?php echo UserModule::t('Profile'); ?></a>
                        </li>
						<li class="name-hover"><a href= <?php echo Yii::app()->homeUrl . '/messages/inbox' ?> ><i class="icon-comment" style="margin:0 5px 0 0;"></i><?php echo UserModule::t('Messages'); ?> <?php echo (Message::model()->getCountUnreaded(Yii::app()->user->getId()) ?
                        ' (' . Message::model()->getCountUnreaded(Yii::app()->user->getId()) . ')' : '') ?></a>
						</li>
                        <li class="divider"></li>
                        <li class="name-hover">
                            <a href=<?php echo Yii::app()->homeUrl . '/user/settings/general' ?>><i class="icon-cog" style="margin:0 5px 0 0;"></i><?php echo UserModule::t('Settings'); ?></a>
                        </li>
                    </ul>                    
                </li>
                <li><a style="display:inline-block;" href= <?php echo Yii::app()->homeUrl . '/user/logout' ?> ><i class="icon-power-off" style="display:inline; margin-right:10px; font-size:15px; line-height:20px;"></i><?php echo UserModule::t("Logout") ?></a></li>
            <?php endif?>
		</ul>
    </div>
    
    <?php 
    if(Yii::app()->getModule('user')->isAdmin()){
        $this->widget('bootstrap.widgets.TbButton', array(
            'id'=>'admin-btn',
            'label'=>'ADMIN',
            //'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'large', // null, 'large', 'small' or 'mini'
            'url'=>$this->createUrl('/user/admin'),//array('unfollow','name'=>$model->name),
        )); 
    } ?>
    
</div>
    
    <?php $this->widget('application.components.LangBox'); ?>
    
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
					<a href="<?php echo Yii::app()->request->baseUrl.'/startup?g=&sec[0]=1'?>">Art</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/startup?g=&sec[0]=2'?>">Creative Economy</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/startup?g=&sec[0]=3'?>">Education</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/startup?g=&sec[0]=4'?>">Entertainment</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/startup?g=&sec[0]=5'?>">Environment</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/startup?g=&sec[0]=6'?>">Financial</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/startup?g=&sec[0]=9'?>">Internet Business</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/startup?g=&sec[0]=14'?>">Technology</a>
				</li>		 
			</ul>
		</div>
		<div class="col fol">
			<span class="col-head">Usuários</span>
			<ul>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/user?g=Investidores'?>">Investidores</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/user?g=Empreendedores'?>">Empreendedores</a>
				</li>
			</ul>
		</div>
		<div class="col fol">
			<span class="col-head">Sobre</span>
			<ul>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl?>">Sobre Nós</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl?>">Como Funciona</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl?>">Ajuda</a>
				</li>
			</ul>
		</div>
		<div class="col fol">
			<span class="col-head">Navegue</span>
			<ul>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/startup'?>">Startups</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl.'/user'?>">Usuários</a>
				</li>
				<li>
					<a href="<?php echo Yii::app()->request->baseUrl?>">Pitches</a>
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

<script>
				$(function() {
	
	var img_path = "<?php echo Yii::app()->request->baseUrl.'/images/'?>";
	
    $("#main_search").autocomplete({
        source: function( request, response ) {
			$.ajax({
				beforeSend: function(){
					 $(".team-loading").html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif'/>");
				},
				url: "<?php echo Yii::app()->request->baseUrl.'/site/autotest'?>",
				data: {term: request.term},
				dataType: "json",
				success: function( data ) {
					response( $.map( data.myData, function( item ) {
						return {
							value: item.label,
							description: item.description,
							label: _highlight(item.label, request.term),
							label_form: item.label,
							image: item.image,
							uname: item.uname
							
						}
					}));
					$(".team-loading").empty();
					$(".ui-autocomplete").css({'width':'300px'});
				},
				error: function(){
					$(".team-loading").empty();
					$(".ui-autocomplete").css({'display':'none'});
				}
			});
		},
        minLength: 1,
		delay: 300,
		select: function( event, ui ) {
			$( "#main_search" ).val( ui.item.label_form);
			return false;
      }
    }).data( "uiAutocomplete" )._renderItem = function( ul, item ) {
        var inner_html = '<a href="<?php echo Yii::app()->request->baseUrl; ?>/' + item.uname + '"><div class="list_item_container"><div class="image"><img src="' + img_path + item.image + '"></div><div class="aa">' + item.label + '</div><div class="description">' + item.description + '</div></div></a>';
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
	
	function _highlight(s, t) {
		var matcher = new RegExp("("+$.ui.autocomplete.escapeRegex(t)+")", "ig" );
		return s.replace(matcher, "<strong>$1</strong>");
	}
});
			</script>
		

</body>
</html>
