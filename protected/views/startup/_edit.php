<?php

$p_product = empty($model->product_description) ? 1 : 0;

$p_stage = empty($model->company_stage) ? 1 : 0;

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js', CClientScript::POS_END);


Yii::app()->clientScript->registerScript('loading-img',
"	
	
	$(document).ready(function(){ 
		
		$('#imagem').live('change',function(){ $('.mult-img-loading').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\" alt=\"Enviando...\"/>');
		
		$('#formulario').ajaxForm({ 
			dataType: 'json',		
			type: 'POST',
			data: {
				YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
			},
			success: function(data){
				if(data.res=='no')
				{
					$('.mult-img-loading').html(data.msg);
				}
				else
				{
					$('#visualizar').append(data.res);
					$('.mult-img-loading').empty();
					$('.mult-list-img').animate({opacity: 1}, 500);
				}
			}
		}).submit(); }); 
		
		if($('.alert-error').length)
		{
			$('.err-publish').css({'display':'inline'});
		}
	});
	
	$('.start-name').on('click','.editable-submit', function(event){
		//$('.header-label').html('aaa');
		
		setTimeout(function(){
			if(!$('.start-name').find('a').hasClass('editable-open'))
			{
				$('.container').css({'opacity':'0.6'});
				$('.container').prepend('<div class=\"mask\" style=\"position:absolute; left:0; height:100%; width:100%; background-color:transparent; z-index:999;\"></div>')
				$('.profile-header-edit').prepend('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\" />')
			}
		}, 500);
		
		setTimeout(function(){
			if(!$('.start-name').find('a').hasClass('editable-open'))
			{
			
				var new_name = $('.start-name').find('a').text();
				
				$.ajax({
					url: '".Yii::app()->request->baseUrl."/startup/refreshStartupName?id=".$model->id."',
					dataType: 'json',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					success: function(data){
						location.href = data.res;	
					}
				});
			}
			else
			{
				$('.container').css({'opacity':'1'});
				$('.mask').hide();
			}
		}, 2000);
		
		
			
	});
	
	$('.start-sector').on('click','.editable-submit', function(event){
		setTimeout(function(){
			if(!$('.start-sector').find('a').hasClass('editable-open'))
			{
				$('.err-sector').animate({opacity: 0}, 500);
				
				if(".count($model->sectors)."==0 && !$('.bar').parent().hasClass('p-sec'))
				{
					var width = $('.bar').width();
					var parentWidth = $('.bar').parent().width();
					var percent = width/parentWidth;
					percent=percent+0.1;
					var new_width=parentWidth*percent;

					$('.bar').css({'width':new_width});
				
					checkCompletionBar(percent*100);
					$('.bar').parent().addClass('p-sec');
					
				}
				
				
			}
		}, 1000);
	});
	
	$('.start-product').on('click','.editable-submit', function(event){
		setTimeout(function(){
			if(!$('.start-product').find('a').hasClass('editable-open'))
			{
				$('.err-product').animate({opacity: 0}, 500);

				if(".$p_product." && !$('.bar').parent().hasClass('p-product'))
				{
					var width = $('.bar').width();
					var parentWidth = $('.bar').parent().width();
					var percent = width/parentWidth;
					percent=percent+0.1;
					var new_width=parentWidth*percent;

					$('.bar').css({'width':new_width});
				
					checkCompletionBar(percent*100);
					$('.bar').parent().addClass('p-product');
					
				}
			}
		}, 1000);
	});
	
	$('.start-stage').on('click','.editable-submit', function(event){
		setTimeout(function(){
			if(!$('.start-stage').find('a').hasClass('editable-open'))
			{
				$('.err-stage').animate({opacity: 0}, 500);
				
				if(".$p_stage." && !$('.bar').parent().hasClass('p-stage'))
				{
					var width = $('.bar').width();
					var parentWidth = $('.bar').parent().width();
					var percent = width/parentWidth;
					percent=percent+0.1;
					var new_width=parentWidth*percent;

					$('.bar').css({'width':new_width});
				
					checkCompletionBar(percent*100);
					$('.bar').parent().addClass('p-stage');
					
				}
			}
		}, 1000);
	});

	$('#visualizar').on('click','.mult-list-img-wrap',function(event){
		$('.mult-img-loading').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\" alt=\"Enviando...\"/>')
		var elem = $(this);
		var imgname = elem.attr('data-name');
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/multDel?name=".$model->startupname."&imgname='+imgname+'',
				dataType: 'json',
				type: 'POST',
				data: {
					YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
				},
				success: function(data){
					$('.mult-img-loading').empty();
					elem.animate({opacity: 0}, 500, function(){
						elem.hide();
					});
					
				}
			});
	});

	
	$('.pic-btn').click(function(event){
		$('#pic-btn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
	});
	
	$('.team-ready').on('mouseover','.team-item',function(event){
		$(this).find('.team-delete').css({'color':'red', 'font-size':'22px'});	
	});
	
	$('.team-ready').on('mouseout','.team-item',function(event){
		$(this).find('.team-delete').css({'color':'#ccc', 'font-size':'15px'});	
	});
	
	$('.press-ready').on('mouseover','.press-item',function(event){
		$(this).find('.press-delete').css({'color':'red', 'font-size':'22px'});	
	});
	
	$('.press-ready').on('mouseout','.press-item',function(event){
		$(this).find('.press-delete').css({'color':'#ccc', 'font-size':'15px'});	
	});
	
	$('.traction-ready').on('mouseover','.traction-item',function(event){
		$(this).find('.traction-delete').css({'color':'red', 'font-size':'22px'});	
	});
	
	$('.traction-ready').on('mouseout','.traction-item',function(event){
		$(this).find('.traction-delete').css({'color':'#ccc', 'font-size':'15px'});	
	});
	
	$('.past-ready').on('mouseover','.past-item',function(event){
		$(this).find('.past-delete').css({'color':'red', 'font-size':'22px'});	
	});
	
	$('.past-ready').on('mouseout','.past-item',function(event){
		$(this).find('.past-delete').css({'color':'#ccc', 'font-size':'15px'});	
	});
	
	$('.nav li:contains(\"Home\")').addClass('xuxu');
	
	$('.profile-editable-content').mouseover(function(event) {
		$(this).find('.pic-btn').addClass('btn-primary').removeClass('disabled');	
	});
	
	$('.profile-editable-content').mouseout(function(event) {
		$(this).find('.pic-btn').removeClass('btn-primary').addClass('disabled');	
	});
	
	$('.arrow-container').mouseover(function(event){
		$(this).css('background-color', '#fefefe');
	});
	
	$('.arrow-container').mouseout(function(event){
		$(this).css('background-color', '#f6f6f6');
	});
	
	$('.content-head').click(function(event){
		
		if(!$(this).hasClass('clicked'))
		{
			$(this).removeClass('rounded');
			$(this).next().slideDown();
			$(this).addClass('clicked');
			$(this).find('.arrow').removeClass('arrow-down');
			$(this).find('.arrow').addClass('arrow-up');
		}
		
		else
		{
			$(this).next().slideUp(function(){
				$(this).prev().addClass('rounded');
			});
			$(this).removeClass('clicked');
			$(this).find('.arrow').removeClass('arrow-up');
			$(this).find('.arrow').addClass('arrow-down');
			
		}
		
	});

	
	$('#form-team').submit(function(event) {
		
		event.preventDefault(); 
		$('.team-btn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/addTeam?name=".$model->startupname."',
				dataType: 'json',
				type: 'POST',
				data: $('#form-team').serialize(),
				success: function(data){
					if(data.res=='no')
					{
						$('#form-team').find('.team-error').html(data.msg);
						$('.team-btn').text('Save')
					}
					else
					{
						$('.team-error').html('');
						$('.team-ready').prepend(data.res);
						$('.team-item').show('slow').animate({opacity: 1}, 250);	
						$('.team-btn').text('Save')
					}
				}
			});
		
		
	});
	
		$('#form-press').submit(function(event) {
		
		event.preventDefault(); 
		$('.press-btn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/addPress?name=".$model->startupname."',
				dataType: 'json',
				type: 'POST',
				data: $('#form-press').serialize(),
				success: function(data){
					if(data.res=='no')
					{
						$('#form-press').find('.press-error').html(data.msg);
						$('.press-btn').text('Save');
					}
					else
					{
						$('.press-error').html('');	
						$('.press-ready').prepend(data.res);
						$('.press-item').show('slow').animate({opacity: 1}, 250);
						$('.press-btn').text('Save');
					}
				}
			});
		
		
	});
	
	$('#form-traction').submit(function(event) {
		
		event.preventDefault(); 
		$('.traction-btn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/addTraction?name=".$model->startupname."',
				dataType: 'json',
				type: 'POST',
				data: $('#form-traction').serialize(),
				success: function(data){
					if(data.res=='no')
					{
						$('#form-traction').find('.traction-error').html(data.msg);
						$('.traction-btn').text('Save');
					}
					else
					{
						$('.traction-error').html('');	
						$('.traction-ready').prepend(data.res);
						$('.traction-item').show('slow').animate({opacity: 1}, 250);
						$('.traction-btn').text('Save');
					}
				}
			});
		
		
	});
	
	$('#form-past').submit(function(event) {
		
		event.preventDefault(); 
		$('.past-btn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/addPast?name=".$model->startupname."',
				dataType: 'json',
				type: 'POST',
				data: $('#form-past').serialize(),
				success: function(data){
					if(data.res=='no')
					{
						$('#form-past').find('.past-error').html(data.msg);
						$('.past-btn').text('Save');
					}
					else
					{
						$('.past-error').html('');	
						$('.past-ready').prepend(data.res);
						$('.past-item').show('slow').animate({opacity: 1}, 250);
						$('.past-btn').text('Save');
					}
					$('#investor_id').val('');
					$('#investor').val('');
					$('#value-past').val('');
					$('#date-past').val('');
				}
			});
		
		
	});
	
	
	$('.team-ready').on('click','.team-delete',function(event){
		if(confirm('Are you sure?'))
		{
			var parent = $(this).parent();
			var id = parent.find('span').attr('data-id');
			parent.addClass('deletable');
			$.ajax({
					url: '".Yii::app()->request->baseUrl."/startup/deleteTeam?id='+id+'&name=".$model->startupname."',
					dataType: 'json',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					success: function(data){
						
						if(data.res=='OK')
							$('.deletable').animate({opacity: 0}, 100).hide('slow', function(){ $('.deletable').remove(); });
						
						else
						{
							$('.deletable').removeClass('deletable');	
							parent.find('.team-error').html(data.msg);
						}					
						
					},
					error: function(){
						$('.deletable').removeClass('deletable');	
					}
				});
		}
	
	});
	
	$('.press-ready').on('click','.press-delete',function(event){
		if(confirm('Are you sure?'))
		{
			var parent = $(this).parent();
			var id = parent.find('span').attr('data-id');
			parent.addClass('deletable');
			$.ajax({
					url: '".Yii::app()->request->baseUrl."/startup/deletePress?id='+id+'&name=".$model->startupname."',
					dataType: 'json',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					success: function(data){
						
						if(data.res=='OK')
							$('.deletable').animate({opacity: 0}, 100).hide('slow', function(){ $('.deletable').remove(); });
						
						else
						{
							$('.deletable').removeClass('deletable');	
							parent.find('.press-error').html(data.msg);
						}					
						
					},
					error: function(){
						$('.deletable').removeClass('deletable');	
					}
				});
		}
	
	});
	
	$('.traction-ready').on('click','.traction-delete',function(event){
		if(confirm('Are you sure?'))
		{
			var parent = $(this).parent();
			var id = parent.find('span').attr('data-id');
			parent.addClass('deletable');
			$.ajax({
					url: '".Yii::app()->request->baseUrl."/startup/deleteTraction?id='+id+'&name=".$model->startupname."',
					dataType: 'json',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					success: function(data){
						
						if(data.res=='OK')
							$('.deletable').animate({opacity: 0}, 100).hide('slow', function(){ $('.deletable').remove(); });
						
						else
						{
							$('.deletable').removeClass('deletable');	
							parent.find('.traction-error').html(data.msg);
						}					
						
					},
					error: function(){
						$('.deletable').removeClass('deletable');	
					}
				});
		}
	
	});
	
	
	$('.past-ready').on('click','.past-delete',function(event){
		if(confirm('Are you sure?'))
		{
			var parent = $(this).parent();
			var id = parent.find('span').attr('data-id');
			parent.addClass('deletable');
			$.ajax({
					url: '".Yii::app()->request->baseUrl."/startup/deletePast?id='+id+'&name=".$model->startupname."',
					dataType: 'json',
					type: 'POST',
					data: {
						YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
					},
					success: function(data){
						
						if(data.res=='OK')
							$('.deletable').animate({opacity: 0}, 100).hide('slow', function(){ $('.deletable').remove(); });
						
						else
						{
							$('.deletable').removeClass('deletable');	
							parent.find('.past-error').html(data.msg);
						}					
						
					},
					error: function(){
						$('.deletable').removeClass('deletable');	
					}
				});
		}
	
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

function checkCompletionBar(percent)
{
	var bar_parent = $('.bar').parent();
	bar_parent.removeClass('progress-danger').removeClass('progress-warning').removeClass('progress-success');
	
	if(percent<=40)
			bar_parent.addClass('progress-danger');
		else if(percent>40 && percent<75)
			bar_parent.addClass('progress-warning');
		else
			bar_parent.addClass('progress-success');
}

");

?>

<div class="spacing-1"></div>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true,
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array(),
    'userComponentId' => 'user',
    'alerts' => array( // configurations per alert type
        // success, info, warning, error or danger
        
        'error' => array('block' => false, 'closeText' => '&times;'),
		'warning' => array('block' => false, 'closeText' => false),
    ),
));?>

<div class="completion-bar" style="margin-bottom: 30px; overflow:auto;">
	<span style="float:left; margin-right: 20px;">Completion:</span>
	<?php
		
		if($model->completion<=40)
			$type="danger";
		else if($model->completion>40 && $model->completion<75)
			$type="warning";
		else
			$type="success";
		
		echo "<div style='float:left; width: 300px; border:2px solid #ccc; border-radius:5px;'>";
		$this->widget('bootstrap.widgets.TbProgress', array(
			'percent'=>$model->completion, // the progress
			'striped'=>true,
			'animated'=>true,
			'type'=>$type,
			'htmlOptions'=>array('style'=>'margin:0;'),
		));
		echo "</div>";
	?>
</div>

<div class="profile-header-edit">	

	<div id="startup-profile-img">
		<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$model->logo0->name ?>"/>
	</div>
	
	<div class="profile-edit-header">
	
		
		<div class="editable-wrap profile-editable-content">
			<div class="content-info-unit">
				<div class="header-label">
					<b>Nome:</b> 
				</div>
					<span class="start-name">
						<?php $this->widget('bootstrap.widgets.TbEditableField', array(
							'type'      => 'text',
							'model'     => $model,
							'attribute' => 'name',
							'url'       => array('updateName'),  
							'placement' => 'right',
							'inputclass'=> 'input-large',
							'mode'=>'inline',
							'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
							'options'    => array(
								'tpl'=>'<input type="text" class="input-large" style="padding-right: 24px;" maxlength="40">'
							)
						 )); ?>  
					</span>
			</div>
			
			<div class="content-info-unit">			
				<div class="header-label">
					<b>Pitch de uma linha:</b> 
				</div>
					<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'one_line_pitch',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-large',
						'mode'=>'inline',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'options'    => array(
							'tpl'=>'<input type="text" class="input-large" style="padding-right: 24px;" maxlength="80">'
						)
					 )); ?>  
			</div>
			
			<div class="content-info-unit">			
				<div class="header-label">
					<b>Setor(es):</b> 
				</div>
				<span class="start-sector">
					<?php           
					$this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'select2',
						'model'     => $model,
						'attribute' => 'sec',
						'url'       => $this->createUrl('updateSectors'), 
						'source'    => CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'),
						'text'      => $model->getSectorCommaNames(),  
						'value'     => $model->getSectorCommaIds(),
						'placement' => 'right',
						'inputclass'=> 'input-large',
						'emptytext' => 'Vazio',
						'options' => array(
							'value'=>$model->getSectorIds(),
						),
						'select2'   => array(
							'placeholder'=> 'Select...',
							'multiple'=>true,
							'maximumSelectionSize'=> 3,
						),
						'mode'=>'inline',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'onHidden' => 'js: function(e, reason) {
							$("#select2-drop-mask").css("display","none");
							$("#select2-drop").css("display","none");
						}',
					)); ?>
					<div class="err-publish err-sector" style="display:none; margin-left:30px; color:#b94a48;"><?php if(!$model->sectors) echo UserModule::t("Required"); ?></div>
				</span>	
			</div>
				
			<div class="content-info-unit">			
				<div class="header-label">
					<b>Cidade:</b> 
				</div>
					<?php           
					$this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'select2',
						'model'     => $model,
						'attribute' => 'location',
						'url'       => $this->createUrl('updateLocation'), 
						'source'    => Cidade::model()->getCities(),
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'select2'   => array(
							'placeholder'=> 'Select...',
							'allowClear'=> true,   
							'dropdownAutoWidth'=> true,
							'minimumInputLength'=> 3,
						),
						'mode'=>'inline',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'onHidden' => 'js: function(e, reason) {
							$("#select2-drop-mask").css("display","none");
							$("#select2-drop").css("display","none");
						}',
					)); ?> 
			</div>
				
			<div class="content-info-unit">			
				<div class="header-label">
					<b>Logo:</b> 
				</div>
				
				<div class="header-content">
					<!-- !!!!!!!!!!!!!! image form begin!!!!!!!!!!!!!!!!-->
		
					<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'logo-edit-form',
						'type'=>'horizontal',
						'clientOptions'=>array(
							'validateOnSubmit'=>true,
						),
						'enableClientValidation'=>true,
						'htmlOptions' => array(
							'enctype' => 'multipart/form-data'
						),
						'inlineErrors'=>false,
					)); 
					?>
					
					<div class="pic-wrap">
						<?php echo $form->fileFieldRow($model, 'pic', array('labelOptions' => array('label' => ''))); ?>
						<!-- necessário isso aqui, por causa da classe de errorcss<?php echo $form->error($model,'pic', array('errorCssClass'=>'', 'successCssClass'=>'' )); ?>-->
					</div>
					
					<?php $this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'submit',
							'id'=>'pic-btn',
							'label'=>'Upload',
							'size'=>'normal',
							'htmlOptions'=>array(
								'class'=>'pic-btn disabled',
								'style'=>'width:70px;',
							),
							)); 
					?>
					
					
					<?php $this->endWidget(); ?>
					
					<!-- !!!!!!!!!!!!!! image form end !!!!!!!!!!!!!!!!-->
				</div>
					
			</div>
				
				
			</div>
	</div>
	
	<span class="teste" style="float:right;">
			
			<?php if($model->published==1):?>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Voltar',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/'.CHtml::encode($model->startupname)),
					)); 
				?>
			<?php else:?>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Publicar',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('publish','name'=>CHtml::encode($model->startupname)),
					)); 
				?>	
			<?php endif;?>
			
			
		
		</span>
	


</div>
	



<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-lightbulb profile-icon"></i>O Produto 
			<div class="err-publish err-product" style="display:none; margin-left:30px; color:#b94a48; font-size:15px; font-weight:normal; letter-spacing:0;"><?php if(!$model->product_description) echo UserModule::t("Required"); ?></div>
			<span class="tip">Descreva o produto detalhadamente</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap">
				<span class="start-product">
					<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
							'type'      => 'textarea',
							'model'     => $model,
							'attribute' => 'product_description',
							'url'       => array('update'),  
							'placement' => 'right',
							'inputclass'=> 'input-xlarge',
							'emptytext' => 'Vazio',
							'mode'=>'inline',
							'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						 )); ?>  
									
					</p>
				</span>
			</div>
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-youtube-play profile-icon"></i> Video
			<span class="tip">Link para video do youtube</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'video',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'mode'=>'inline',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
					 )); ?>  
				</p>
			</div>
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-picture profile-icon"></i> Imagens
			<span class="tip">Insira até 4 imagens do seu produto (resize para 500 x 312px)</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<!--
			<div class="editable-wrap editable-img">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'mult-image-edit-form',
					'htmlOptions' => array('enctype' => 'multipart/form-data'), 
				)); ?>
				
				<div class="pic-wrap">
					<?php
						$this->widget('CMultiFileUpload', array(
							'model'=>$model,
							'name'=>'mult_pic',
							'accept' => 'jpeg|jpg|gif|png',
							'max'=>4-count($model->images),
							// useful for verifying files
							'duplicate' => 'Arquivo duplicado!', // useful, i think
							'denied' => '', // useful, i think
						));
					?>
				</div>
			
			
			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'id'=>'pic-mult',
						'label'=>'Upload',
						'size'=>'normal',
						'htmlOptions'=>array(
							'class'=>'pic-btn',
						),
						)); 
				?>
			</div>
	
	<?php $this->endWidget(); ?>
	-->		
			<div class="mult-pic-preview"></div>
			
			
			<form id="formulario" method="post" enctype="multipart/form-data" action="<?php echo Yii::app()->request->baseUrl.'/startup/multUp?name='.$model->startupname; ?>"> 
			
			<input type="file" id="imagem" name="imagem" /> <div class="mult-img-loading" style="display:inline;"></div>
			
			</form> 
			
			<div id="visualizar">
				<?php foreach($model->images as $img) :?>
					<div class="mult-list-img-wrap" data-name="<?php echo $img->name;?>" style="float:left; width: 100px; height:80px; line-height:80px; text-align:center; margin:0 20px 20px 0; background: #f6f6f6; border-radius: 3px;" data-toggle="tooltip" data-html=true data-original-title="clique para deletar">
						<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$img->name ?>" class="mult-list-img" style="max-width: 100px; max-height:63px;"/>
					</div>
				<?php endforeach; ?>
			</div>

			
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-link profile-icon"></i> Website & Social
			<span class="tip">Edite os links para o Website da empresa e para as Redes Sociais</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap">
				<p> <i class="icon-globe web"></i>    
					<?php $this->widget('editable.EditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'website',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'options'=>array(
                            'defaultValue'=>'http://www.'
                        ),
						'mode'=>'inline'
					 )); ?>  
				</p>
				
				<p> <img class="social-edit-img" src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png'?>"/>     
					<?php $this->widget('editable.EditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'facebook',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'options'=>array(
                            'defaultValue'=>'https://www.facebook.com/',
                        ),
						'mode'=>'inline'
					 )); ?>  
				</p>
				
				<p> <img class="social-edit-img" src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png'?>"/>
					<?php $this->widget('editable.EditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'twitter',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'options'=>array(
                            'defaultValue'=>'https://www.twitter.com/',
                        ),
						'mode'=>'inline'
					 )); ?>  
				</p>
				
				<p> <img class="social-edit-img" src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png'?>"/>   
					<?php $this->widget('editable.EditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'linkedin',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'options'=>array(
                            'defaultValue'=>'http://www.linkedin.com/pub/'
                        ),
						'mode'=>'inline'
					 )); ?>  
				</p>
			</div>
		</div>
		
	</div>		
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-cogs profile-icon"></i> Tecnologia
			<span class="tip">Tecnologia utilizada no produto</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'tech',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-screenshot profile-icon"></i> Público Alvo
			<span class="tip">Pessoas ou Grupos a quem se destinam o produto</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'client_segment',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-money profile-icon"></i> Geração de Renda
			<span class="tip">Como sua Startup gera dinheiro?</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'revenue_generation',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-warning-sign profile-icon"></i> Principais Concorrentes
			<span class="tip">Outros Players que atuam na mesma área</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'competitors',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-trophy profile-icon"></i> Vantagem Competitiva
			<span class="tip">Qual o diferencial da sua empresa?</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'competitive_advantage',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-book profile-icon"></i> História da Empresa
			<span class="tip">Breve histórico da Startup</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'history',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'emptytext' => 'Vazio',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head" style="border-radius: 5px 5px 0 0;">
			<i class="icon-book profile-icon"></i> Traction
			<span class="tip">Métricas do desenvolvimento da empresa</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit" style="border-radius: 0;">
			
			<div class="editable-wrap-team">
		
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'form-traction',
					'action'=>'',
					'htmlOptions' => array('enctype' => 'multipart/form-data'), 
				)); ?>
		
					<?php echo CHtml::label('Metric', false, array('style'=>'display:block; margin-right:30px;')); ?>
					<?php echo CHtml::textField('metric'); ?>
					
					<?php echo CHtml::label('Value', false, array('style'=>'display:block; margin-right:30px;')); ?>
					<?php echo CHtml::textField('value'); ?>
					
					<?php echo CHtml::label('Period', false); ?>
					<?php echo CHtml::dropDownList('period', '', array_merge(array(''=>UserModule::t("Select...")), $model->getTractionPeriodOptions())) ?>
			
					
					<?php echo CHtml::label('Data', false, array('style'=>'display:block; margin-right:30px;')); ?>
					<?php $this->widget('bootstrap.widgets.TbDatePicker', array(
							'name' => 'date-traction',
							'options' => array(
								'format' => 'yyyy-mm-dd',
							),
						)); 
					?>
					
					
			
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'label'=>'Save',
						'size'=>'normal',
						'htmlOptions'=>array(
							'style'=>'display:block; width:65px;',
							'class'=>'traction-btn btn-primary',
							),
						)); 
					?>
					<div class="traction-error" style="display:inline; margin-left:10px; color:#b94a48;"></div>
			
				<?php $this->endWidget(); ?>
				
			</div>
			
		</div>	
	
	<div class="content-info traction-ready" id="traction-approve">
		
		<?php 
			$qry = new CDbCriteria(array(
				'condition' => "startup_id=:param",
				'order' => "date DESC",
				'params' => array(':param' => $model->id),  
			));

			$query = Traction::model()->findAll($qry); 
				
			foreach($query as $traction):  
		?>		
		<div class="traction-item">		
			<div class="traction-text">
				<table>
					<tr>
						<td><div class="tracion-metric"><span data-id="<?php echo CHtml::encode($traction->id); ?>"><?php echo CHtml::encode($traction->metric); ?></div></td>
						<td><div class="traction-value"><?php echo CHtml::encode($traction->value); ?></div></td>
						<td><div class="traction-period"><?php echo CHtml::encode($traction->period);?></div></td>
						<td><div class="traction-date"><?php echo date('d/m/y', strtotime(CHtml::encode($traction->date))); ?></div></td>
					<tr>
				</table>
			</div>
			<div class="traction-delete"><i class="icon-remove-sign"></i></div>
			<div class="traction-error"></div>
		</div>
		<?php endforeach;?>
		
		
		</div>	
	
	</div>	
	
	<div class="content-wrap">

		<div class="content-head" style="border-radius: 5px 5px 0 0;">
			<i class="icon-book profile-icon"></i> Past Investments
			<span class="tip">Investimentos do passado</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit" style="border-radius: 0;">
			
			<div class="editable-wrap-team">
		
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'form-past',
					'action'=>'',
					'htmlOptions' => array('enctype' => 'multipart/form-data'), 
				)); ?>
		
					<?php echo CHtml::label('Investidor', false, array('style'=>'display:inline-block; margin-right:30px;')); ?><div class="past-loading" style="display:inline;"></div>
					<input type="text" id="investor" size="40" name="past_investor_name" style="display:block;"/>
					<input type="hidden" id="investor_id" name="past_investor_id"/>
					
					<?php echo CHtml::label('Value', false, array('style'=>'display:block; margin-right:30px;')); ?>
					<?php echo CHtml::textField('value-past'); ?>
							
					
					<?php echo CHtml::label('Data', false, array('style'=>'display:block; margin-right:30px;')); ?>
					<?php $this->widget('bootstrap.widgets.TbDatePicker', array(
							'name' => 'date-past',
							'options' => array(
								'format' => 'yyyy-mm-dd',
							),
						)); 
					?>
					
					
			
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'label'=>'Save',
						'size'=>'normal',
						'htmlOptions'=>array(
							'style'=>'display:block; width:65px;',
							'class'=>'past-btn btn-primary',
							),
						)); 
					?>
					<div class="past-error" style="display:inline; margin-left:10px; color:#b94a48;"></div>
			
				<?php $this->endWidget(); ?>
				
			</div>

			<script>
				$(function() {
	
	var img_path = "<?php echo Yii::app()->request->baseUrl.'/images/'?>";
	
    $("#investor").autocomplete({
        source: function( request, response ) {
			$.ajax({
				beforeSend: function(){
					 $(".past-loading").html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif'/>");
				},
				url: "<?php echo Yii::app()->request->baseUrl.'/startup/autotest'?>",
				data: {term: request.term},
				dataType: "json",
				success: function( data ) {
					response( $.map( data.myData, function( item ) {
						return {
							value: item.label,
							id: item.value,
							description: item.description,
							label: _highlight(item.label, request.term),
							label_form: item.label,
							image: item.image
							
						}
					}));
					$(".past-loading").empty();
					$(".ui-autocomplete").css({'width':'300px'});
				},
				error: function(){
					$(".past-loading").html('<span style="color:#b94a48;"> Registro não encontrado! </span>').find('span').delay(1000).fadeOut(600);
					$(".ui-autocomplete").css({'display':'none'});
				}
			});
		},
        minLength: 1,
		delay: 300,
		select: function( event, ui ) {
			$( "#investor" ).val( ui.item.label_form);
			$( "#investor_id" ).val( ui.item.id );
			return false;
      }
    }).data( "uiAutocomplete" )._renderItem = function( ul, item ) {
        var inner_html = '<a><div class="list_item_container"><div class="search-image"><img src="' + img_path + item.image + '"></div><div class="aa">' + item.label + '</div><div class="description">' + item.description + '</div></div></a>';
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
		</div>	
	
	<div class="content-info past-ready" id="past-approve">
		
		<?php 
			$qry = new CDbCriteria(array(
				'condition' => "startup_id=:param",
				'order' => "date DESC",
				'params' => array(':param' => $model->id),  
			));

			$query = PastInvestment::model()->findAll($qry); 
				
			foreach($query as $past):  
		?>		
		<div class="past-item">		
				<table>
					<tr>
						<?php if(empty($past->user_id)):?>
						<td>
							<div class="past-image"><?php echo '<img src="'.Yii::app()->request->baseUrl.'/images/default-user.png" id="past-img" />'; ?></div>
							<div class="past-investor"><span data-id="<?php echo CHtml::encode($past->id); ?>"><?php echo CHtml::encode($past->investor_name); ?></div></td>
						</td>
						<?php else:?>
						<?php $usr=User::model()->find('user_id=:u_id', array(':u_id'=>$past->user_id)); ?>
						<td>
							<div class="past-image"><?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$usr->profile->logo->name.'" id="past-img" />', array('/' . $usr->username)); ?></div>
							<div class="past-investor"><span data-id="<?php echo CHtml::encode($past->id); ?>"><?php echo CHtml::link(CHtml::encode($usr->getFullName()), array('/' . $usr->username)); ?></div></td>
						</td>
						<?php endif;?>
						<td><div class="past-value"><?php echo CHtml::encode($past->value); ?></div></td>
						<td><div class="past-date"><?php echo date('d/m/y', strtotime(CHtml::encode($past->date))); ?></div></td>
					</tr>
				</table>
			<div class="past-delete"><i class="icon-remove-sign"></i></div>
			<div class="past-error"></div>
		</div>
		<?php endforeach;?>
		
		
		</div>	
	
	</div>	

</div>

<div class="profile-column-r">
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-signal profile-icon"></i> Estágio
			<div class="err-publish err-stage" style="display:none; margin-left:30px; color:#b94a48; font-size:15px; font-weight:normal; letter-spacing:0;"><?php if(!$model->company_stage) echo UserModule::t("Required"); ?></div>
			<span class="tip">Indique o Estágio de Desenvolvimento do Produto</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
			
		<div class="content-info edit">
			<div class="editable-wrap">
				<span class="start-stage">
					<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
							'type'      => 'select',
							'model'     => $model,
							'attribute' => 'company_stage',
							'url'       => array('update'),  
							'source'    => array_merge(array(''=>UserModule::t("Select...")), $model->getCompanyStageOptions()), 
							'placement' => 'right',
							'emptytext' => 'Vazio',
							'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
							'mode'=>'inline',
						 )); ?>  
										
					</p>
				</span>
			</div>
				
		</div>
		
	</div>	
	
	<!--
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-building profile-icon"></i>Tamanho
			<span class="tip">Número de membros da Startup</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
			
		<div class="content-info edit">
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'select',
						'model'     => $model,
						'attribute' => 'company_size',
						'url'       => array('update'),  
						'source'    => $model->getCompanySizeOptions(), 
						'placement' => 'right',
						'emptytext' => 'Vazio',
						'mode'=>'inline',
					 )); ?>  
									
				</p>
			</div>
				
		</div>
		
	</div>	
	-->
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-calendar profile-icon"></i> Data
			<span class="tip">Indique a data de início das atividades</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
			
		<div class="content-info edit" style="overflow:visible;">
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'combodate',
                        'model'     => $model,
                        'attribute' => 'foundation',
                        'url'       => array('update'),  
                        'mode'      => 'popup',
						'emptytext' => 'Vazio',
                        'placement' => 'left',
                        'format'      => 'YYYY-MM-DD', //format in which date is expected from model and submitted to server
                        'viewformat'  => 'DD/MM/YYYY', //format in which date is displayed
                        'template'    => 'D / MMM / YYYY',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                        'options'   => array(
                            'defaultValue'   => date('Y-m-d'),
                        )
					 )); ?>  
									
				</p>
			</div>
				
		</div>
		
	</div>		
			
	
	<div class="content-wrap">

		<div class="content-head" style="border-radius: 5px 5px 0 0;">
			<i class="icon-group profile-icon"></i> Equipe
			<span class="tip">Insira os usuários relacionados com a startup</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit" style="border-radius: 0;">
			
			<div class="editable-wrap-team">
		
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'form-team',
					'action'=>'',
					'htmlOptions' => array('enctype' => 'multipart/form-data'), 
				)); ?>
		
					<?php echo CHtml::label('Nome', false, array('style'=>'display:inline-block; margin-right:30px;')); ?><div class="team-loading" style="display:inline;"></div>
					<input type="text" id="my_ac" size="40" />
					<input type="hidden" id="my_ac_id" name="user_startup"/>
					
					<?php echo CHtml::label('Papel', false); ?>
					<?php echo CHtml::activeDropDownList($model,'user_role', array_merge(array(''=>UserModule::t("Select...")), $model->getCompanyPositionOptions()), array('name'=>'position')) ?>
			
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'label'=>'Save',
						'size'=>'normal',
						'htmlOptions'=>array(
							'style'=>'display:inline-block; width:65px;',
							'class'=>'team-btn btn-primary',
							),
						)); 
					?>
					<div class="team-error" style="display:inline; margin-left:10px; color:#b94a48;"></div>
			
				<?php $this->endWidget(); ?>
				
			</div>
			
			<script>
				$(function() {
	
	var img_path = "<?php echo Yii::app()->request->baseUrl.'/images/'?>";
	
    $("#my_ac").autocomplete({
        source: function( request, response ) {
			$.ajax({
				beforeSend: function(){
					 $(".team-loading").html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif'/>");
				},
				url: "<?php echo Yii::app()->request->baseUrl.'/startup/autotest'?>",
				data: {term: request.term},
				dataType: "json",
				success: function( data ) {
					response( $.map( data.myData, function( item ) {
						return {
							value: item.label,
							id: item.value,
							description: item.description,
							label: _highlight(item.label, request.term),
							label_form: item.label,
							image: item.image
							
						}
					}));
					$(".team-loading").empty();
					$(".ui-autocomplete").css({'width':'300px'});
				},
				error: function(){
					$(".team-loading").html('<span style="color:#b94a48;"> Registro não encontrado! </span>').find('span').delay(1000).fadeOut(600);
					$(".ui-autocomplete").css({'display':'none'});
				}
			});
		},
        minLength: 1,
		delay: 300,
		select: function( event, ui ) {
			$( "#my_ac" ).val( ui.item.label_form);
			$( "#my_ac_id" ).val( ui.item.id );
			return false;
      }
    }).data( "uiAutocomplete" )._renderItem = function( ul, item ) {
        var inner_html = '<a><div class="list_item_container"><div class="search-image"><img src="' + img_path + item.image + '"></div><div class="aa">' + item.label + '</div><div class="description">' + item.description + '</div></div></a>';
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
		
		</div>	
	</div>


<div class="content-wrap" style="margin-top:0px;">
        
        <?php $array=UserStartup::model()->findAll('startup_id=:s_id AND approved=0', array(':s_id'=>$model->id)); ?>
        <?php if(count($array)>0): ?>
        
        <div class="content-info team-ready">
            <?php foreach($array as $ar):  ?>	

            <div class="team-item">		
                <div class="team-image"><?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$ar->user->profile->logo->name.'" id="team-img" />', array('/' . $ar->user->username)); ?></div>
                <div class="team-text">
                    <div class="team-name">
                        <?php echo CHtml::link(CHtml::encode($ar->user->getFullName()),array('/' . $ar->user->username), array('class'=>'startup-view-name'));?>                        
                    </div>
                    <div class="team-position"><?php echo CHtml::encode(UserModule::t($ar->position));?></div>
                </div>
                    <?php                
                    $this->widget(
                        'bootstrap.widgets.TbButton',
                        array(
                            'label' => 'Delete',
                            'buttonType'=>'ajaxButton',
                            'size' => 'small',
                            'type'=>'danger',
                            'url'=>Yii::app()->createUrl('/user/user/deleterelation', array('uid'=>$ar->user->id, 'sid'=>$model->id)), 
                            'htmlOptions'=>array('style'=>'float: right;'),
                            'ajaxOptions'=>array(
                                'type'=>'POST',
                                'data'=>array(
                                    'YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken,
                                ),
                                'context'=>'this',
                                'success'=> '$.proxy(function(response) { 
                                    $(this).parent().animate({opacity: 0}, 100).hide("slow");
                                    }, $(this)
                                )',
                            )
                        )
                    );
                    ?>
                    <?php                
                    $this->widget(
                        'bootstrap.widgets.TbButton',
                        array(
                            'label' => 'Approve',
                            'buttonType'=>'ajaxButton',
                            'size' => 'small',
                            'type'=>'primary',
                            'url'=>Yii::app()->createUrl('/startup/approve', array('uid'=>$ar->user->id, 'sid'=>$model->id)), 
                            'htmlOptions'=>array('style'=>'float: right; margin-right: 10px;'),
                            'ajaxOptions'=>array(
                                'type'=>'POST',
                                'dataType'=> 'json',
                                'data'=>array(
                                    'YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken,
                                ),
                                'context'=>'this',
                                'success'=> '$.proxy(function(data) { 
                                    alert("Usuário adicionado com sucesso.");
                                    $("#team-approve").append(data.res);
                                    $("#team-approve .team-item").show("slow").animate({opacity: 1}, 250);	
						
                                    $(this).parent().animate({opacity: 0}, 100).hide("slow");
                                    }, $(this)
                                )',
                            )
                        )
                    );
                    ?>
                    
            </div>   
            <?php endforeach;?>
            
        </div>
        
        <!--
        <div class="content-info team-ready2" style="border-radius: 0;">            
            <?php foreach($array as $ar):  ?>	
            <div class="team-item" id="some">	
                <div class="team-name" style="display: inline;"><?php echo $ar->user->getFullName(); ?></div>
                
            </div>
            <?php endforeach;?>
        </div> -->
        <?php endif ?>
        
		<div class="content-info team-ready" id="team-approve">
		
		<?php foreach($model->users1 as $usr_startup):  ?>
		
		<?php $relational_tbl=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id AND approved=1', array(':u_id'=>$usr_startup->id, ':s_id'=>$model->id)); ?>
		<?php if($relational_tbl): ?>
		<div class="team-item">		
			<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
			<div class="team-text">
				<div class="team-name"><span data-id="<?php echo CHtml::encode($usr_startup->id); ?>"><?php echo CHtml::encode($usr_startup->profile->firstname . ' ' . $usr_startup->profile->lastname); ?></span></div>
				<div class="team-position"><?php echo CHtml::encode(UserModule::t($relational_tbl->position));?></div>
				<div class="team-resume"><?php echo CHtml::encode($usr_startup->profile->resume);?></div>
			</div>
			<div class="team-delete"><i class="icon-remove-sign"></i></div>
			<div class="team-error"></div>
		</div>
		<?php endif; ?>
		<?php endforeach;?>
			
		
		
		</div>	
	</div>	
	

	<div class="content-wrap">

		<div class="content-head" style="border-radius: 5px 5px 0 0;">
			<i class="icon-book profile-icon"></i> Press
			<span class="tip">Notícias na mídia</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit" style="border-radius: 0;">
			
			<div class="editable-wrap-team">
		
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'form-press',
					'action'=>'',
					'htmlOptions' => array('enctype' => 'multipart/form-data'), 
				)); ?>
		
					<?php echo CHtml::label('URL', false, array('style'=>'display:inline-block; margin-right:30px;')); ?><div class="press-loading" style="display:inline;"></div>
					<?php echo CHtml::urlField('url', '', array('id' => 'url')); ?>
					
					<?php echo CHtml::label('Titulo', false, array('style'=>'display:inline-block; margin-right:30px;')); ?>
					<?php echo CHtml::textField('title', '', array('id' => 'title')); ?>
					
					<?php echo CHtml::label('Descrição', false, array('style'=>'display:inline-block; margin-right:30px;')); ?>
					<?php echo CHtml::textArea('description'); ?>
					
					<?php echo CHtml::label('Data', false, array('style'=>'display:inline-block; margin-right:30px;')); ?>
					<?php $this->widget('bootstrap.widgets.TbDatePicker', array(
							'name' => 'date',
							'options' => array(
								'format' => 'yyyy-mm-dd',
							),
						)); 
					?>
					
					
			
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'label'=>'Save',
						'size'=>'normal',
						'htmlOptions'=>array(
							'style'=>'display:inline-block; width:65px;',
							'class'=>'press-btn btn-primary',
							),
						)); 
					?>
					<div class="press-error" style="display:inline; margin-left:10px; color:#b94a48;"></div>
			
				<?php $this->endWidget(); ?>
				
			</div>
			
<script>
				$(function() {
	
    $("#url").autocomplete({
        source: function( request, response ) {
			$.ajax({
				beforeSend: function(){
					 $(".press-loading").html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif'/>");
				},
				url: "<?php echo Yii::app()->request->baseUrl.'/startup/pressurl'?>",
				data: {term: request.term},
				dataType: "json",
				success: function( data ) {
					$("#title").val(data.title);
					$(".press-loading").empty();
					$(".ui-autocomplete").css({'display':'none'});
				},
				error: function(){
					$(".press-loading").html('<span style="color:#b94a48;"> Não encontrado! </span>').find('span').delay(1000).fadeOut(600);
					$(".ui-autocomplete").css({'display':'none'});
				}
			});
		},
        minLength: 1,
		delay: 500
    });
	
});
			</script>		
			
		</div>	
	
	<div class="content-info press-ready" id="press-approve">
		
		<?php foreach($model->press as $press):  ?>		
		<div class="press-item">		
			<div class="press-text">
				<?php 
				/* manipulate url */ 
				$url=preg_replace('/http:\/\//', '', $press->url);
				$url=preg_replace('/https:\/\//', '', $url);
				if(strpos($url, '/'))
					$url=strstr($url, '/', true);
				?>
				<div class="press-url"><span data-id="<?php echo CHtml::encode($press->id); ?>"><?php echo CHtml::encode($url); ?></div>
				<div class="press-title"><?php echo CHtml::link(CHtml::encode($press->title), CHtml::encode($press->url), array('target'=>'_blank'));?></div>
				<div class="press-description"><?php echo CHtml::encode($press->description);?></div>
				<div class="press-date"><?php echo date('d/m/y', strtotime(CHtml::encode($press->time))); ?></div>
			</div>
			<div class="press-delete"><i class="icon-remove-sign"></i></div>
			<div class="press-error"></div>
		</div>
		<?php endforeach;?>
		
		
		</div>	
	
	</div>	
	
	
	
	<?php echo CHtml::beginForm(Yii::app()->request->baseUrl.'/startup/delete/id/'.CHtml::encode($model->id), 'post'); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'label'=>'Delete',
				'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'mini', // null, 'large', 'small' or 'mini'
				'url'=>array('/startup/delete/id/'.CHtml::encode($model->id)),
				'htmlOptions'=>array('onClick'=>'return confirm("'.UserModule::t("Are you sure?").'\n'.UserModule::t("This action has no return!").'");'),
				
				
				)); 
		?>
	<?php echo CHtml::endForm(); ?>

</div>

