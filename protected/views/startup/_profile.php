		
	

	<?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$model->logo0->name.'" id="Startup-list-img" alt="asdasd" />', array('view', 'name'=>$model->name)); ?>
	
	<?php echo CHtml::link(CHtml::encode($model->name),array('view','name'=>$model->name));?>
	<br />
	
	<h1>
<?php
    $this->widget('bootstrap.widgets.TbEditableField', array(
        'type'      => 'text',
        'model'     => $model,
        'attribute' => 'name',
        'url'       => array('update'),  //url for submit data          
        'placement' => 'right',
     ));
     
?>
</h1>



<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Edit',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
	'url'=>array(''),
)); ?>



<fieldset>
<legend>Company</legend>
<div class="">
    <p> <?php echo '<b>One Line Pitch: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'one_line_pitch',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
    
    <p> <?php echo '<b>Company Size: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'select',
            'model'     => $model,
            'attribute' => 'company_size',
            'url'       => array('update'),  
            'source'    => '',//$profile->getGenderOptions(), 
            'placement' => 'right',
         )); ?> 
    </p>
	
	<p> <?php echo '<b>Company Stage: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'select',
            'model'     => $model,
            'attribute' => 'company_stage',
            'url'       => array('update'),  
            'source'    => '',//$profile->getGenderOptions(), 
            'placement' => 'right',
         )); ?> 
    </p>
	
	 <p> <?php echo '<b>Foundation: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'date',
            'model'     => $model,
            'attribute' => 'foundation',
            'url'       => array('update'),  
            'placement' => 'right',
            'format'      => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
            'viewformat'  => 'dd/mm/yyyy', //format in which date is displayed
         )); ?>  
    </p>
	
	<p> <?php echo '<b>Email: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'email',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	<p> <?php echo '<b>Telephone: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'telephone',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	<p> <?php echo '<b>Skype: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'skype',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	<p> <?php echo '<b>One Line Pitch: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'company_number',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	
	
</div>
</fieldset>




	
	
<!--
	<b><?php echo CHtml::encode($model->getAttributeLabel('one_line_pitch')); ?>:</b>
	<?php echo CHtml::encode($model->one_line_pitch); ?>
	<br />

	
	<b><?php echo CHtml::encode($model->getAttributeLabel('foundation')); ?>:</b>
	<?php echo CHtml::encode($model->foundation); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($model->email); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('telephone')); ?>:</b>
	<?php echo CHtml::encode($model->telephone); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('skype')); ?>:</b>
	<?php echo CHtml::encode($model->skype); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('company_number')); ?>:</b>
	<?php echo CHtml::encode($model->company_number); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('facebook')); ?>:</b>
	<?php echo CHtml::encode($model->facebook); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('twitter')); ?>:</b>
	<?php echo CHtml::encode($model->twitter); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('blog')); ?>:</b>
	<?php echo CHtml::encode($model->blog); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($model->address); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('client_segment')); ?>:</b>
	<?php echo CHtml::encode($model->client_segment); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('value_proposition')); ?>:</b>
	<?php echo CHtml::encode($model->value_proposition); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('market_size')); ?>:</b>
	<?php echo CHtml::encode($model->market_size); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('sales_marketing')); ?>:</b>
	<?php echo CHtml::encode($model->sales_marketing); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('revenue_generation')); ?>:</b>
	<?php echo CHtml::encode($model->revenue_generation); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('competitors')); ?>:</b>
	<?php echo CHtml::encode($model->competitors); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('competitive_advantage')); ?>:</b>
	<?php echo CHtml::encode($model->competitive_advantage); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('video')); ?>:</b>
	<?php echo CHtml::encode($model->video); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($model->create_time); ?>
	<br />
-->
	 

