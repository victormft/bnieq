<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.carouFredSel-6.2.1.js');

Yii::app()->clientScript->registerScript('script',
"

$(document).ready(function() {

	// Using custom configuration
	$('#foo').carouFredSel({
		items				: 2,
		direction			: 'up',
		scroll : {
			items			: 1,
			easing			: 'elastic',
			duration		: 100,							
			pauseOnHover	: true
		}					
	});	
	
	
});


");



?>




<?php

$this->widget('bootstrap.widgets.TbCarousel', array(
  'items'=>array(
      array(
		'image'=>Yii::app()->request->baseUrl.'/images/edicios-sp-gray.jpg',
		'label'=>'First Thumbnail label',
		'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. ' .
			'Donec id elit non mi porta gravida at eget metus. ' .
			'Nullam id dolor id nibh ultricies vehicula ut id elit.',
		'imageOptions'=>array(
			'style'=>'width:100%; height: 400px;',
			),
		),	
      array(
		'image'=>'http://placehold.it/830x400&text=Second+thumbnail',
		'label'=>'Second Thumbnail label',
		'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. ' .
			'Donec id elit non mi porta gravida at eget metus. ' .
			'Nullam id dolor id nibh ultricies vehicula ut id elit.',
		
		'imageOptions'=>array(
			'style'=>'width:100%; height: 400px;',
			),
		
		),
      array(
		'image'=>'http://placehold.it/830x400&text=Third+thumbnail',
		'label'=>'Third Thumbnail label',
		'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. ' .
			'Donec id elit non mi porta gravida at eget metus. ' .
			'Nullam id dolor id nibh ultricies vehicula ut id elit.',
			
		'imageOptions'=>array(
			'style'=>'width:100%; height: 400px;',
			),	
			
		),
  ),
  
  /*
  'htmlOptions'=>array(
	'style'=>'width:500px;'
		
  
  ),
  */
  
));

?>



<ul id="foo">
	<li> c </li>
	<li> a </li>
	<li> r </li>
	<li> o </li>
	<li> u </li>
	<li> F </li>
	<li> r </li>
	<li> e </li>
	<li> d </li>
	<li> S </li>
	<li> e </li>
	<li> l </li>
</ul>


<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Welcome to '.CHtml::encode(Yii::app()->name),
)); ?>

<p>Congratulations! You have successfully created your Yii application. EEEE</p>

<?php $this->endWidget(); ?>

<p>You may change the content of this page by modifying the following two files:</p>

<ul>
    <li>View file: <code><?php echo __FILE__; ?></code></li>
    <li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
</ul>

<p>For more details on how to further develop this application, please read
    the <a href="http://www.yiiframework.com/doc/">documentation</a>.
    Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
    should you have any questions.</p>
