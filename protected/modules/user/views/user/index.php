
<?php
Yii::app()->clientScript->registerScript('search',
"

$(document).ready(function() {
    if(getUrlVars()['sec[0]'])
	{
		$('#search-sector').css('display', 'block');
	}
});

$('#searchform').change(function(event) {
    var g = (getUrlVars()['g'] == null) ? '' : getUrlVars()['g'];

    var n = ($('#n').val()=='') ? '' : '&n='+encodeURIComponent($('#n').val());

    var sec=[]; 
    $('input[type=checkbox]:checked').each(function(){
        sec.push($(this).val());
    });

    var secs = '';

    for (var i = 0, len = sec.length; i < len; i++) {
        secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);

    };

    location.href = 'user?g='+g+n+secs;
});

$('.g').click(function(event) {
    var g = $(this).text();
    var n = (getUrlVars()['n'] == null) ? '' : '&n='+getUrlVars()['n'];

    var sec=[]; 
    $('input[type=checkbox]:checked').each(function(){
        sec.push($(this).val());
    });

    var secs = '';

    for (var i = 0, len = sec.length; i < len; i++) {
        secs=secs+'&sec['+i+']='+encodeURIComponent(sec[i]);

    };

    location.href = 'user?g='+g+n+secs;
			
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


$('.sec-label').click(function(event) {

    if(!$('.sec-label').hasClass('clicked'))
    {
        $('#search-sector').slideDown('slow');
        $('.sec-label').addClass('clicked');
    }

    else
    {
        $('#search-sector').slideUp('slow');
        $('.sec-label').removeClass('clicked');
    }
		
});
");
?>

<h1>Users</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider->search(),
'itemView'=>'_view',
'id'=>'startupslistview',       // must have id corresponding to js above
'sorterHeader'=>'Ordenar por: ',
 'sortableAttributes'=>array(
        'firstname',
		'resume',
        'fullname'
    ),
'template'=>'{items} {pager}',
)); ?>

<div class="search-form">
	
	<div id="G-Selection">
		<div class="group-title">Busca Rápida</div>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Investidores") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-star profile-icon"></i>Investidores</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Empreendedores") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-group profile-icon"></i>Empreendedores</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['g']) && $_GET['g']=="Mais seguidos") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-calendar profile-icon"></i>Mais seguidos</p></a>
		<a class="g" href="user"><p class="last-p" <?php if(isset($_GET['g']) && $_GET['g']=="Todas") echo 'style="background:#fff; color:#333; font-size:17px;"'; ?>><i class="icon-asterisk profile-icon"></i>Todos</p></a>
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

            <?php //echo CHtml::activeLabel($dataProvider,'company_size'); ?>

            <?php //echo CHtml::activeDropDownList($dataProvider,'company_size', array_merge(array(''=>'Selecione...'), $dataProvider->getCompanySizeOptions()), array('name'=>'c_size')) ?>

            <div>

            <?php echo CHtml::label('Roles >', false, array('class'=>'sec-label')); ?>

            <div id="search-sector">
                <?php echo CHtml::activeCheckBoxList($dataProvider,'roles', CHtml::listData(Role::model()->findAll(), 'role_id', 'name'), array('name'=>'sec', 'labelOptions'=>array('style'=>'display:inline'))) 
                ?>
            </div>

            </div>

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
