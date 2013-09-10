



<h1>Users</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider->search(),
'itemView'=>'_view',
'enableHistory' => TRUE,
'pagerCssClass' => "pagination",
'id'=>'startupslistview',       // must have id corresponding to js above
'template'=>'{items} {pager}',
)); ?>


<div class="search-form">
	<?php 
	//$this->renderPartial('_customsearch',array(
	//'dataProvider'=>$dataProvider,
	//)); 
	?>
	
	<div id="G-Selection">
		<div class="group-title">Group Selection</div>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['group']) && $_GET['group']=="Selecionadas") echo 'style="background:#fff;"'; ?>>Selecionadas</p></a>
		<a class="g" href="javascript:void(0)"><p <?php if(isset($_GET['group']) && $_GET['group']=="Todas") echo 'style="background:#fff;"'; ?>>Todas</p></a>
		<p>asdsd</p>
		<p>asdsd</p>
	</div>
	
	<div class="form-vertical">
    <?php echo CHtml::beginForm('startup', 'get', array('id'=>'searchform')); ?>


    <div class="row">
        <?php //echo CHtml::label('Nome', false); ?>
        
		<div id="search-name">
			<?php echo CHtml::encode($dataProvider->getAttributeLabel('firstname')); ?>
			
			<?php	
			$this->widget('bootstrap.widgets.TbButton',array(
				'label' => 'Search',
				'size' => 'small'
			));
			?>
		</div>
			
	</div>
    <?php echo CHtml::endForm(); ?> 
	<!-- form -->
	</div><!-- search-form -->
</div>
