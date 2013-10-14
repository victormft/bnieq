<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div id="sidebar-right-wrap">
        <div id="sidebar">
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operações',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        </div><!-- sidebar -->
    </div>
    <div class="span12">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    
</div>
<?php $this->endContent(); ?>