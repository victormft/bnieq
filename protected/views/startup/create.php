<?php
$this->layout='column1';
?>

<h1 class="create-title">Criar Startup</h1>
<div class="create-sub-title">Forneça os dados necessários para criar o perfil da Startup!</div>

<div class="create-wrap">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>