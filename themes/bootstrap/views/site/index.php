<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.carouFredSel-6.2.1.js');

Yii::app()->clientScript->registerScript('script',
"

$(document).ready(function() {

	$('.carousel').carousel()

	// Using default configuration
	$('#foo').carouFredSel({
		items				: 2,
		direction			: 'up',
		scroll : {
			items			: 1,
			easing			: 'elastic',
			duration		: 1000,							
			pauseOnHover	: true
		}					
	});	
	
	$('#startup_carousel .items').carouFredSel({
		items : 4,
		auto : false,
		prev : '#startup_carousel_prev',
		next : '#startup_carousel_next'
	});	
	
		
});
	
");



?>

<div id="yw0" class="carousel slide">
	<div class="carousel-inner">
		<div class="item active">
			<img style="width:100%; height: 400px;" src="/bnieq/images/edicios-sp-gray.jpg" alt="">
		</div>
		<div class="item">
			<img style="width:100%; height: 400px;" src="http://placehold.it/830x400&amp;text=Second+thumbnail" alt="">
		</div>
		<div class="item">
			<img style="width:100%; height: 400px;" src="http://placehold.it/830x400&amp;text=Third+thumbnail" alt="">
		</div>
	</div>
	
	<a class="carousel-control left" href="#yw0" data-slide="prev">&lsaquo;</a>
	<a class="carousel-control right" href="#yw0" data-slide="next">&rsaquo;</a>
</div>


<?php


/*
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
  
  
  //'htmlOptions'=>array(
//	'style'=>'width:500px;'
		
  
 // ),
  
  
));
*/

?>

<hr>

Site Description

<hr>


<!-- !!!!!!!!! Carousel !!!!!!!!!! -->

<div style="margin-bottom:20px; position:relative;">

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider->search(),
'itemView'=>'_carousel',
'id'=>'startup_carousel',
'template'=>'{items}',
)); 
?>
	<div class="clearfix"></div>
	<a class="startup_carousel_control prev" id="startup_carousel_prev" href="#"><span>&lsaquo;</span></a>
	<a class="startup_carousel_control next" id="startup_carousel_next" href="#"><span>&rsaquo;</span></a>
	<div class="pagination" id="foo5_pag"></div>
</div>



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