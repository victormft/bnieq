<div class="about-wrap" style="margin-top:30px;">	
	<div class="info-left" style="width:650px; float:left; border: 1px solid #ccc; border-radius:5px; background-color:#fff;">
		termos texto!!!!
	</div>

	<div class="menu-right" style="width:250px; float:right; background-color:#fff; border-radius:5px; border:1px solid #ccc;">

			<?php echo CHtml::link('Como Funciona?', array('/about/como-funciona')); ?>

			<?php echo CHtml::link('Quem Somos?', array('/about/quem-somos')); ?>

			<?php echo CHtml::link('Ajuda', array('/about/ajuda')); ?>
			
			<?php echo CHtml::link('Termos', array('/about/termos'), array('class'=>'clicked')); ?>
	</div>
</div>