<div class="cards-wrap">
    <?php foreach($provider as $arr):  ?>
    <div class="startup-card">
        <div class="startup-pic" style="overflow: auto;"><?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$arr->profile->logo->name.'"/>', array('/' . $arr->username)); ?> </div>
        <div class="startup-name"><?php echo CHtml::link($arr->getFullName(), array('/' . $arr->username)); ?></div>
    </div>
    <?php endforeach;  ?>
</div>
