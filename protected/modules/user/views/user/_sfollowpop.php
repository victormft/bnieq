<div class="cards-wrap">
    <?php foreach($provider as $arr):  ?>
    <div class="startup-card">
        <div class="startup-pic" style="overflow: auto;"><?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$arr->logo0->name.'" id="startup-card-img"/>', array('startup/view', 'name'=>$arr->startupname)); ?> </div>
        <div class="startup-name"><?php echo CHtml::link(CHtml::encode($arr->name), array('startup/view','name'=>$arr->startupname)); ?></div>
    </div>
    <?php endforeach;  ?>
</div>
