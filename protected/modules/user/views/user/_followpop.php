<div class="cards-wrap">
    <?php foreach($provider as $arr):  ?>
    <div class="startup-card">
        <div class="startup-pic" style="overflow: auto;"><?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$arr->$attr->profile->logo->name.'" id="startup-card-img"/>', array('/' . $arr->$attr->username)); ?> </div>
        <div class="startup-name"><?php echo CHtml::link($arr->$attr->getFullName(), array('/' . $arr->$attr->username)); ?></div>
    </div>
    <?php endforeach;  ?>
</div>
