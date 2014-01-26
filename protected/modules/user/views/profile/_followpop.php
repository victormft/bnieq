<div class="cards-wrap">
    <?php foreach($provider as $arr):  ?>
    <div class="startup-card">
        <div class="startup-pic" style="overflow: auto;"><?php echo CHtml::link('<img src="http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$arr->$attr->profile->logo->name.'"/>', array('/' . $arr->$attr->username)); ?> </div>
        <div class="startup-name"><?php echo CHtml::link($arr->$attr->getFullName(), array('/' . $arr->$attr->username)); ?></div>
    </div>
    <?php endforeach;  ?>
</div>
