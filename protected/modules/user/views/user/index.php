<?php $this->pageTitle=Yii::app()->name . ' - ' . UserModule::t("Users") . ''; ?>

<?php
Yii::app()->clientScript->registerScript('search',
"

$(document).ready(function() {
    if(getUrlVars()['rol[0]'])
	{
		$('#search-role').css('display', 'block');
	}
    if(getUrlVars()['ski[0]'])
	{
		$('#search-skill').css('display', 'block');
	}
    if(getUrlVars()['sec[0]'])
	{
		$('#search-sector').css('display', 'block');
	}
});

$('#searchform').change(function(event) {
    var g = (getUrlVars()['g'] == null) ? '' : getUrlVars()['g'];

    var n = ($('#n').val()=='') ? '' : '&n='+encodeURIComponent($('#n').val());

    var rol=[]; 
    $('input:checkbox[name=\'rol[]\']:checked').each(function(){
        rol.push($(this).val());
    });

    var rols = '';

    for (var i = 0, len = rol.length; i < len; i++) {
        rols=rols+'&rol['+i+']='+encodeURIComponent(rol[i]);

    };
    
    var ski=[]; 
    $('input:checkbox[name=\'ski[]\']:checked').each(function(){
        ski.push($(this).val());
    });

    var skis = '';

    for (var i = 0, len = ski.length; i < len; i++) {
        skis=skis+'&ski['+i+']='+encodeURIComponent(ski[i]);

    };
    
    var sec=[]; 
    $('input:checkbox[name=\'sec[]\']:checked').each(function(){
        sec.push($(this).val());
    });

    var secs = '';

    for (var i = 0, len = sec.length; i < len; i++) {
        secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);

    };

    location.href = 'user?g='+g+n+rols+skis+secs;
});

$('.g').click(function(event) {
    var g = $(this).text();
    var n = (getUrlVars()['n'] == null) ? '' : '&n='+getUrlVars()['n'];

    var rol=[]; 
    $('input:checkbox[name=\'rol[]\']:checked').each(function(){
        rol.push($(this).val());
    });

    var rols = '';

    for (var i = 0, len = rol.length; i < len; i++) {
        rols=rols+'&rol['+i+']='+encodeURIComponent(rol[i]);

    };
    
    var ski=[]; 
    $('input:checkbox[name=\'ski[]\']:checked').each(function(){
        ski.push($(this).val());
    });

    var skis = '';

    for (var i = 0, len = ski.length; i < len; i++) {
        skis=skis+'&ski['+i+']='+encodeURIComponent(ski[i]);

    };

    var sec=[]; 
    $('input:checkbox[name=\'sec[]\']:checked').each(function(){
        sec.push($(this).val());
    });

    var secs = '';

    for (var i = 0, len = sec.length; i < len; i++) {
        secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);

    };

    location.href = 'user?g='+g+n+rols+skis+secs;
			
});

$('#clean').click(function(event) {
			
    location.href = 'user';
			
});

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


$('.rol-label').click(function(event) {

    if(!$('.rol-label').hasClass('clicked'))
    {
        $('.rol-arrow').removeClass('arrow-down').addClass('arrow-up');
        $('#search-role').slideDown('slow');
        $('.rol-label').addClass('clicked');
    }

    else
    {
        $('#search-role').slideUp('slow', function(){
            $('.rol-arrow').removeClass('arrow-up').addClass('arrow-down');
        });
        $('.rol-label').removeClass('clicked');
    }
		
});

$('.ski-label').click(function(event) {

    if(!$('.ski-label').hasClass('clicked'))
    {
        $('.ski-arrow').removeClass('arrow-down').addClass('arrow-up');
        $('#search-skill').slideDown('slow');
        $('.ski-label').addClass('clicked');
    }

    else
    {
        $('#search-skill').slideUp('slow', function(){
            $('.ski-arrow').removeClass('arrow-up').addClass('arrow-down');
        });
        $('.ski-label').removeClass('clicked');
    }
		
});

$('.sec-label').click(function(event) {

    if(!$('.sec-label').hasClass('clicked'))
    {
        $('.sec-arrow').removeClass('arrow-down').addClass('arrow-up');
        $('#search-sector').slideDown('slow');
        $('.sec-label').addClass('clicked');
    }

    else
    {
        $('#search-sector').slideUp('slow', function(){
            $('.sec-arrow').removeClass('arrow-up').addClass('arrow-down');
        });
        $('.sec-label').removeClass('clicked');
    }
		
});

$(document.body).on('click','.follow-press',function(event){

    var user_name = encodeURIComponent($(this).parent().prev().attr('data-name'));
    var elem = $(this);

    if(elem.text()=='Follow')
    {	
        elem.html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');

        $.ajax({
            url: '".Yii::app()->request->baseUrl."/user/user/follow?username='+user_name,
            type: 'POST',
            dataType: 'json',
            success: function(data){
                elem.removeClass('btn-success');
                elem.removeClass('btn-follow');
                elem.addClass('btn-unfollow');
                elem.text('Unfollow');	
                elem.parent().prev().html(data.res);
            }
        });
    }

    else if(elem.text()=='Unfollow')
    {
        elem.html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');

        $.ajax({
            url: '".Yii::app()->request->baseUrl."/user/user/unfollow?username='+user_name,
            type: 'POST',
            dataType: 'json',
            success: function(data){
                elem.addClass('btn-success');
                elem.removeClass('btn-unfollow');
                elem.addClass('btn-follow');
                elem.text('Follow');
                elem.parent().prev().html(data.res);					
            }
        });
    }
			
});



");
?>

<div class="sub-header-bg"></div>
<h1 class="create-title" style="margin-top:25px;"><?php echo UserModule::t("Users") ?></h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:60px;"><?php echo UserModule::t("Entrepreneurs and Investors of NextBlue") ?></div>

<?php $this->widget('zii.widgets.CListView',array(
'dataProvider'=>$dataProvider->search(),
'itemView'=>'/user/_view',
'id'=>'userslistview',       // must have id corresponding to js above
'pagerCssClass'=>'pagination',
'pager'=>array('header'=>'', 'hiddenPageCssClass'=>'', 'nextPageLabel'=>'>', 'prevPageLabel'=>'<', 'selectedPageCssClass'=>'active',),
'sorterHeader'=>'',
'sortableAttributes'=>array(
    'fullname',
    'followers_count',
),
'template'=>'{sorter} {items} {pager}',
)); ?>

<div class="user-search-form">
	
	<div id="G-Selection">
		<div class="group-title"><?php echo UserModule::t("Quick Search") ?></div>
        <a class="g" href="<?php echo Yii::app()->baseUrl.'/user' ?>"><p <?php if(!isset($_GET['g']) || $_GET['g']=='') echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-asterisk profile-icon"></i><?php echo UserModule::t("All") ?></p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Investidores") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-money profile-icon"></i>Investidores</p></a>
		<a class="g" href="javascript:void(0)"><p class="last-p" <?php if(isset($_GET['g']) && $_GET['g']=="Empreendedores") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-briefcase profile-icon"></i>Empreendedores</p></a>
		
	</div>
	
	<div class="form-vertical">
        <?php echo CHtml::beginForm('user', 'get', array('id'=>'searchform')); ?>

        <div class="column">
            <?php echo CHtml::label('Nome', false); ?>

            <div id="search-name" style="margin-bottom:20px;">
                <?php echo CHtml::activeTextField($dataProvider,'fullname', array('name'=>'n')) ?>

                <?php	
                $this->widget('bootstrap.widgets.TbButton',array(
                    'label' => 'Buscar',
                    'size' => 'small',
                    'id' => 'search-btn'
                ));
                ?>
                
            </div>
            
            <div style="margin-bottom:20px; position:relative;">
                <label class="rol-label"><?php echo UserModule::t('Roles'); ?> <div class="rol-arrow arrow-down" style="display: inline-block; margin-left: 5px;"></div></label>

                <div id="search-role">
                    <?php echo CHtml::activeCheckBoxList($dataProvider,'roles', CHtml::listData(Role::model()->findAll(), 'role_id', 'name'), array('name'=>'rol', 'labelOptions'=>array('style'=>'display:inline'))) 
                    ?>
                </div>
            </div>
            
            <div style="margin-bottom:20px; position:relative;">
                <label class="ski-label"><?php echo UserModule::t('Skills'); ?> <div class="ski-arrow arrow-down" style="display: inline-block; margin-left: 5px;"></div></label>

                <div id="search-skill">
                    <?php echo CHtml::activeCheckBoxList($dataProvider,'skills', CHtml::listData(Skill::model()->findAll(), 'skill_id', 'name'), array('name'=>'ski', 'labelOptions'=>array('style'=>'display:inline'))) 
                    ?>
                </div>
            </div>
            
            <div style="margin-bottom:20px; position:relative;">
                <label class="sec-label"><?php echo UserModule::t('Sectors of interest'); ?> <div class="sec-arrow arrow-down" style="display: inline-block; margin-left: 5px;"></div></label>

                <div id="search-sector">
                    <?php echo CHtml::activeCheckBoxList($dataProvider,'sectors', CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'), array('name'=>'sec', 'labelOptions'=>array('style'=>'display:inline'))) 
                    ?>
                </div>
            </div>

            <div class="spacing-1"></div>
            <div style="text-align:center;">
            <?php	
                $this->widget('bootstrap.widgets.TbButton',array(
                    'id'=>'clean',
                    'label' => 'Limpar',
                    'size' => 'normal'
                ));
                ?>
            </div>

        </div>
        <?php echo CHtml::endForm(); ?>
        <!-- form -->
    </div><!-- search-form -->
</div>
