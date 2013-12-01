<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h2 style="margin-top:60px; text-decoration:underline;"><?php echo UserModule::t("Error");?> <?php echo $code; ?></h2>

<div class="error" style="margin-bottom:40px; font-size:18px;">
<?php echo CHtml::encode($message); ?>
</div>