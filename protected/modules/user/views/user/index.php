
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
        $('#search-role').slideDown('slow');
        $('.rol-label').addClass('clicked');
    }

    else
    {
        $('#search-role').slideUp('slow');
        $('.rol-label').removeClass('clicked');
    }
		
});
");
?>

<div class="spacing-1"></div>

<h1>Users</h1>

<?php $this->widget('zii.widgets.CListView',array(
'dataProvider'=>$dataProvider->search(),
'itemView'=>'_view',
'id'=>'userslistview',       // must have id corresponding to js above
'pagerCssClass'=>'pagination',
'pager'=>array('header'=>'', 'hiddenPageCssClass'=>'', 'nextPageLabel'=>'>', 'prevPageLabel'=>'<', 'selectedPageCssClass'=>'active',),
'sorterHeader'=>'Ordenar por: ',
'sortableAttributes'=>array(
        'firstname',
		'resume',
        'followers_count',
    ),
'template'=>'{sorter} {items} {pager}',
)); ?>

<div class="user-search-form">
	
	<div id="G-Selection">
		<div class="group-title">Busca Rápida</div>
        <a class="g" href="<?php echo Yii::app()->baseUrl.'/user/user' ?>"><p <?php if(!isset($_GET['g']) || $_GET['g']=='') echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-asterisk profile-icon"></i>Todos</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Investidores") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-money profile-icon"></i>Investidores</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Empreendedores") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-briefcase profile-icon"></i>Empreendedores</p></a>
		<a class="g" href="javascript:void(0)"><p class="last-p" <?php if(isset($_GET['g']) && $_GET['g']=="Mais seguidos") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-thumbs-up-alt profile-icon"></i>Mais seguidos</p></a>
		
	</div>
	
	<div class="form-vertical">
        <?php echo CHtml::beginForm('user', 'get', array('id'=>'searchform')); ?>

        <div class="row">
            <?php echo CHtml::label('Nome', false); ?>

            <div id="search-name">
                <?php echo CHtml::activeTextField($dataProvider,'fullname', array('name'=>'n')) ?>

                <?php	
                $this->widget('bootstrap.widgets.TbButton',array(
                    'label' => 'Buscar',
                    'size' => 'small'
                ));
                ?>
                
            </div>
            
            <div>
            <?php echo CHtml::label('Roles >', false, array('class'=>'rol-label')); ?>

            <div id="search-role">
                <?php echo CHtml::activeCheckBoxList($dataProvider,'roles', CHtml::listData(Role::model()->findAll(), 'role_id', 'name'), array('name'=>'rol', 'labelOptions'=>array('style'=>'display:inline'))) 
                ?>
            </div>
            </div>
            
            <div>
            <?php echo CHtml::label('Skills >', false, array('class'=>'rol-label')); ?>

            <div id="search-skill">
                <?php echo CHtml::activeCheckBoxList($dataProvider,'roles', CHtml::listData(Role::model()->findAll(), 'role_id', 'name'), array('name'=>'rol', 'labelOptions'=>array('style'=>'display:inline'))) 
                ?>
            </div>
            </div>

            <div class="spacing-1"></div>
            <div>
            <?php	
                $this->widget('bootstrap.widgets.TbButton',array(
                    'label' => 'Limpar',
                    'size' => 'small'
                ));
                ?>
            </div>

        </div>
        <?php echo CHtml::endForm(); ?>
        <!-- form -->
    </div><!-- search-form -->
</div>
