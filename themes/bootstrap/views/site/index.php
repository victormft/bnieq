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
	
	$('#startup_carousel_all .items').carouFredSel({
		items : 4,
		auto : false,
		circular: false,
		prev : '#startup_carousel_all_prev',
		next : '#startup_carousel_all_next',
		pagination: '#startup_carousel_all_pagination'
	});	
	
	$('#startup_carousel_sel .items').carouFredSel({
		items : 4,
		auto : false,
		circular: false,
		prev : '#startup_carousel_sel_prev',
		next : '#startup_carousel_sel_next',
		pagination: '#startup_carousel_sel_pagination'
	});	
    
    $('#startup_carousel_rec .items').carouFredSel({
		items : 4,
		auto : false,
		circular: false,
		prev : '#startup_carousel_rec_prev',
		next : '#startup_carousel_rec_next',
		pagination: '#startup_carousel_rec_pagination'
	});	
	
	$('.startup_carousel_main').carouFredSel({
		items : 1,
		scroll: {
			duration  : 600
		},
		circular: true,
		prev : '#startup_carousel_main_prev',
		next : '#startup_carousel_main_next',
		pagination: '#startup_carousel_main_pagination'
	});	
	
		
});
	
");



?>
<!--
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
-->

<div style="margin-bottom:20px; margin-top:-20px; position:relative;">
	
	<div class="startup_carousel_main">
		
			<img style="width:1000px; height: 400px;" src="<?php echo Yii::app()->request->baseUrl.'/images/'?>Paulista.jpg" alt="">
			<img style="width:1000px; height: 400px;" src="<?php echo Yii::app()->request->baseUrl.'/images/'?>edicios-sp-gray.jpg" alt="">
			<img style="width:1000px; height: 400px;" src="<?php echo Yii::app()->request->baseUrl.'/images/'?>edicios-sp.jpg" alt="">
		
	</div>
	
	<div class="clearfix"></div>
	<a class="startup_carousel_control prev" id="startup_carousel_main_prev" href="#"><span>&lsaquo;</span></a>
	<a class="startup_carousel_control next" id="startup_carousel_main_next" href="#"><span>&rsaquo;</span></a>
	<div class="pagination carousel-pag" id="startup_carousel_main_pagination"></div>
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

<hr style="border-top: 1px solid #ddd;">

<div class="home-description" style="text-align:center; text-shadow: 2px 2px white; margin:0 auto; width:800px;">
<h1 style="margin-bottom:5px; color:#444; font-weight:normal;">A primeira plataforma de Equity Crowdfunding do Brasil</h1>
<span style="font-size:22px; color:#727272; line-height:30px; font-style:italic;">NextBlue proporciona o contato direto de investidores com Startups de todo o Brasil em uma plataforma de Equity Crowdfunding. Faça parte dessa novidade: uma rede social do investimento!</span>

</div>

<hr style="border-top: 1px solid #ddd; margin-bottom:50px;">


<!-- !!!!!!!!!!!!!!!! Carousel !!!!!!!!!!!!!!!!!! -->
<div style="padding-bottom: 50px;">
<div style="position:absolute; height:644px; width:100%; left:0; right:0; z-index:-1; background:#fff;"></div>
<div class="arrow-all"></div>
<h1 style="font-weight:normal; text-shadow: 1px 1px white; padding-top:60px; margin:0;">Selecionadas</h1>
<span style="font-size:18px; color:#727272; font-style:italic;">As preferidas da equipe do NextBlue</span>
<div style="margin-bottom:20px; position:relative;">

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider->search(20, 1),
'itemView'=>'_carousel',
'id'=>'startup_carousel_all',
'template'=>'{items}',
)); 
?>
	<div class="clearfix"></div>
	<a class="startup_carousel_control prev" id="startup_carousel_all_prev" href="#"><span>&lsaquo;</span></a>
	<a class="startup_carousel_control next" id="startup_carousel_all_next" href="#"><span>&rsaquo;</span></a>
	<div class="pagination carousel-pag" id="startup_carousel_all_pagination"></div>
</div>
</div>

<div style="padding-bottom: 50px;">
<div style="position:absolute; height:654px; width:100%; left:0; right:0; z-index:-1; background:#eaeaea;"></div>
<div class="arrow-sel"></div>
<h1 style="font-weight:normal; text-shadow: 1px 1px white; padding-top:60px; margin:0;">Populares</h1>
<span style="font-size:18px; color:#727272; font-style:italic;">As mais procuradas pelos usuários</span>
<div style="margin-bottom:20px; position:relative;">


<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$popProvider->search(20, 2),
'itemView'=>'_carousel',
'id'=>'startup_carousel_sel',
'template'=>'{items}',
)); 
?>
	<div class="clearfix"></div>
	<a class="startup_carousel_control prev" id="startup_carousel_sel_prev" href="#"><span>&lsaquo;</span></a>
	<a class="startup_carousel_control next" id="startup_carousel_sel_next" href="#"><span>&rsaquo;</span></a>
	<div class="pagination carousel-pag" id="startup_carousel_sel_pagination"></div>
</div>
</div>


<div style="padding-bottom: 50px;">
<div style="position:absolute; height:654px; width:100%; left:0; right:0; z-index:-1; background:#fff;"></div>
<div class="arrow-rec"></div>
<h1 style="font-weight:normal; text-shadow: 1px 1px white; padding-top:60px; margin:0;">Recentes</h1>
<span style="font-size:18px; color:#727272; font-style:italic;">Cadastradas recentemente</span>
<div style="margin-bottom:20px; position:relative;">


<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$recProvider->search(20, 3),
'itemView'=>'_carousel',
'id'=>'startup_carousel_rec',
'template'=>'{items}',
)); 
?>
	<div class="clearfix"></div>
	<a class="startup_carousel_control prev" id="startup_carousel_rec_prev" href="#"><span>&lsaquo;</span></a>
	<a class="startup_carousel_control next" id="startup_carousel_rec_next" href="#"><span>&rsaquo;</span></a>
	<div class="pagination carousel-pag" id="startup_carousel_rec_pagination"></div>
</div>
</div>

<!-- !!!!!!!!!!!!!!!!!! End Carousel !!!!!!!!!!!!!!!!!!!! -->


<!--

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
-->