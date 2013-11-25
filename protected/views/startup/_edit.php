<?php

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
				$('.profile-header').prepend('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\" />')
			}
		}, 500);
		
		setTimeout(function(){
			if(!$('.start-name').find('a').hasClass('editable-open') && !$('.start-name').find('a').hasClass('editable-bg-transition'))
			{
			
				var new_name = $('.start-name').find('a').text();
				
				$.ajax({
					url: '".Yii::app()->request->baseUrl."/startup/updateStartupName?startname='+new_name+'&name=".$model->startupname."',
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
		}, 4000);
		
		
			
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
	
	$('.nav li:contains(\"Home\")').addClass('xuxu');
	
	$('.profile-editable-content').mouseover(function(event) {
		$(this).find('.pic-btn').addClass('btn-primary');	
	});
	
	$('.profile-editable-content').mouseout(function(event) {
		$(this).find('.pic-btn').removeClass('btn-primary');	
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
						$('.team-error').html(data.msg);
						$('.team-btn').text('Save')
					}
					else
					{
						$('.team-error').html('');
						$('.team-ready').append(data.res);
						$('.team-item').show('slow').animate({opacity: 1}, 250);	
						$('.team-btn').text('Save')
					}
				}
			});
		
		
	});
	
	
	$('.team-ready').on('click','.team-delete',function(event){
		var id = $(this).parent().find('span').attr('data-id');
		$(this).parent().addClass('deletable');
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/deleteTeam?id='+id+'&name=".$model->startupname."',
				dataType: 'json',
				type: 'POST',
				data: {
					YII_CSRF_TOKEN: '".Yii::app()->request->csrfToken."',
				},
				success: function(data){
					$('.deletable').animate({opacity: 0}, 100).hide('slow', function(){ $('.deletable').remove(); });
					
				},
				error: function(){
					$('.deletable').removeClass('deletable');	
				}
			});
	
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

<div class="profile-header">	

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
							'url'       => array('update'),  
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
								'class'=>'pic-btn',
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
	
	<!--
	<div class="sectors_wrap">
		<?php //$this->renderPartial('_sectors', array('model'=>$model)); ?>
	</div>
	-->

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
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'select',
						'model'     => $model,
						'attribute' => 'company_stage',
						'url'       => array('update'),  
						'source'    => $model->getCompanyStageOptions(), 
						'placement' => 'right',
						'emptytext' => 'Vazio',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'mode'=>'inline',
					 )); ?>  
									
				</p>
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
							'style'=>'display:inline-block',
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
		</div>
		<?php endif; ?>
		<?php endforeach;?>
			
		
		
		</div>	
	</div>	

</div>

