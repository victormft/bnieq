
<?php
Yii::app()->clientScript->registerScript('search',
"

$(document).ready(function() {
    if(getUrlVars()['rol[0]'])
	{
		$('#search-role').css('display', 'block');
	}
});

$('#searchform').change(function(event) {
    var g = (getUrlVars()['g'] == null) ? '' : getUrlVars()['g'];

    var n = ($('#n').val()=='') ? '' : '&n='+encodeURIComponent($('#n').val());

    var rol=[]; 
    $('input[type=checkbox]:checked').each(function(){
        rol.push($(this).val());
    });

    var rols = '';

    for (var i = 0, len = rol.length; i < len; i++) {
        rols=rols+'&rol['+i+']='+encodeURIComponent(rol[i]);

    };

    location.href = 'user?g='+g+n+rols;
});

$('.g').click(function(event) {
    var g = $(this).text();
    var n = (getUrlVars()['n'] == null) ? '' : '&n='+getUrlVars()['n'];

    var rol=[]; 
    $('input[type=checkbox]:checked').each(function(){
        rol.push($(this).val());
    });

    var rols = '';

    for (var i = 0, len = rol.length; i < len; i++) {
        rols=rols+'&rol['+i+']='+encodeURIComponent(rol[i]);

    };

    location.href = 'user?g='+g+n+rols;
			
});

$('#yw2').click(function(event) {
			
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
");
?>


<h1 class="create-title" style="margin-top:25px;">Usuários</h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:40px;">Empreendedores e Investidores do NextBlue</div>

<?php $this->widget('zii.widgets.CListView',array(
'dataProvider'=>$dataProvider->search(),
'itemView'=>'/user/_view',
'id'=>'userslistview',       // must have id corresponding to js above
'pagerCssClass'=>'pagination',
'pager'=>array('header'=>'', 'hiddenPageCssClass'=>'', 'nextPageLabel'=>'>', 'prevPageLabel'=>'<', 'selectedPageCssClass'=>'active',),
'sorterHeader'=>'',
'sortableAttributes'=>array(
        'followers_count',
    ),
'template'=>'{sorter} {items} {pager}',
)); ?>

<div class="user-search-form">
	
	<div id="G-Selection">
		<div class="group-title">Busca Rápida</div>
        <a class="g" href="<?php echo Yii::app()->baseUrl.'/user' ?>"><p <?php if(!isset($_GET['g']) || $_GET['g']=='') echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-asterisk profile-icon"></i>Todos</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Investidores") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-money profile-icon"></i>Investidores</p></a>
		<a class="g" href="javascript:void(0)"><p class="last-p" <?php if(isset($_GET['g']) && $_GET['g']=="Empreendedores") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-briefcase profile-icon"></i>Empreendedores</p></a>
		
	</div>
	
	<div class="form-vertical">
        <?php echo CHtml::beginForm('user', 'get', array('id'=>'searchform')); ?>

        <div class="row">
            <?php echo CHtml::label('Nome', false); ?>

            <div id="search-name" style="margin-bottom:20px;">
                <?php echo CHtml::activeTextField($dataProvider,'fullname', array('name'=>'n')) ?>

                <?php	
                $this->widget('bootstrap.widgets.TbButton',array(
                    'label' => 'Buscar',
                    'size' => 'small'
                ));
                ?>
                
            </div>
            
            <div style="margin-bottom:20px; position:relative;">
                <?php echo CHtml::label('Roles', false, array('class'=>'rol-label')); ?><div class="rol-arrow arrow-down" style="position: absolute; top: 0; margin-left: 40px; margin-top: 8px;"></div>

                <div id="search-role">
                    <?php echo CHtml::activeCheckBoxList($dataProvider,'roles', CHtml::listData(Role::model()->findAll(), 'role_id', 'name'), array('name'=>'rol', 'labelOptions'=>array('style'=>'display:inline'))) 
                    ?>
                </div>
            </div>

            <div class="spacing-1"></div>
            <div style="text-align:center;">
            <?php	
                $this->widget('bootstrap.widgets.TbButton',array(
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
