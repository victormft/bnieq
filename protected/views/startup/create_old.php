<?php
$this->layout='column1';
?>

<div class="sub-header-bg"></div>
<h1 class="create-title">Criar Startup</h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:60px;">Forneça os dados necessários para criar o perfil da Startup!</div>

<div class="create-wrap">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>