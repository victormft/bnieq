<?php

Yii::app()->clientScript->registerScript('follow',
"

$('#form-contact').submit(function(event) {
		
		event.preventDefault(); 
		$('.contact-btn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/about/addContact',
				dataType: 'json',
				type: 'POST',
				data: $('#form-contact').serialize(),
				success: function(data){
					if(data.res=='no')
					{
						$('#form-contact').find('.contact-info').html(data.msg);
						$('.contact-btn').text('Post');
					}
					else
					{
						$('.contact-info').html(data.msg);			
						$('.contact-btn').text('Post');
					}
				}
			});
		
		
});

");

?>

<div class="about-wrap" style="margin-top:30px;">	
	<div class="info-left" style="width:650px; float:left; border: 1px solid #ccc; border-radius:5px; background-color:#fff; padding:30px; box-shadow: 0px 1px 6px 0px #bbb;">
		<div class="title" style="font-size:25px; font-weight:bold; margin-bottom:40px;">Entre em contato!</div>
		
		<div class="info" style="width:200px; margin-right:30px; float:left; margin-bottom: 100px;">
			<div class="subtitle" style="font-weight:bold; margin-bottom:5px;">Info:</div>
			<span class="text"> 
				blabla<br/>
				elelele
			</span>
		</div>
		
		<div class="info" style="width:200px; margin-right:30px; float:left; margin-bottom: 100px;">
			<div class="subtitle" style="font-weight:bold; margin-bottom:5px;">Info:</div>
			<span class="text"> 
				blabla<br/>
				elelele
			</span>
		</div>
		
		<?php if(!Yii::app()->user->isGuest):?>
		
			<div style="clear:both;">
				
				<div class="title" style="font-size:25px; font-weight:bold; margin-bottom:40px;">Envie uma mensagem!</div>
				
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'form-contact',
					'action'=>'',
					'htmlOptions' => array('enctype' => 'multipart/form-data'), 
				)); ?>
		
					<?php echo CHtml::label('Text', false, array('style'=>'display:block; margin-right:30px;')); ?>
					<?php echo CHtml::textField('text'); ?>
					
			
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'label'=>'Post',
						'size'=>'normal',
						'htmlOptions'=>array(
							'style'=>'display:block; width:65px;',
							'class'=>'contact-btn btn-primary',
							),
						)); 
					?>
					<div class="contact-info" style="display:inline; margin-left:10px; color:#b94a48;"></div>
			
				<?php $this->endWidget(); ?>
			
			</div>
		
		<?php else: ?>
			<div style="clear:both;">
				<p style="text-align:center;">Você precisa estar logado para postar mensagem</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			</div>
		<?php endif; ?>
		
	</div>

	<div class="menu-right" style="width:250px; float:right; background-color:#fff; border-radius:5px; border:1px solid #ccc; box-shadow: 0px 1px 6px 0px #bbb;">

			<?php echo CHtml::link('Como Funciona?', array('/about/como-funciona')); ?>

			<?php echo CHtml::link('Quem Somos?', array('/about/quem-somos')); ?>

			<?php echo CHtml::link('Ajuda', array('/about/ajuda')); ?>
			
			<?php echo CHtml::link('Termos', array('/about/termos')); ?>
			
			<?php echo CHtml::link('Contato', array('/about/contato'), array('class'=>'clicked')); ?>
	</div>
</div>