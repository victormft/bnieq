<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-ui-1.10.3.custom.js');



Yii::app()->clientScript->registerScript('loading-img',
"

	$('#yw3').click(function(event) {
		$('#yw3').html('Loading...');	
	});
	
	$('#yw2').click(function(event) {
		window.location.reload(true);	
	});

	
	$('#form-chonga').submit(function(event) {
		$('#yw13').html('Saulo Baitola');
		
		event.preventDefault(); 
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/chonga?name='+getUrlVars()['name'],
				dataType: 'json',
				type: 'POST',
				data: $('#form-chonga').serialize(),
				success: function(data){
					$('.crazy').append('<div style=\"height:100px; width: 100px; background:#fdfdfd; border: 1px solid #ddd;  margin-bottom:10px;\">'+ data.res +'</div>');
						
				}
			});
		
		
	});
	
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

");

?>

<div class="profile-header">	

	<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$model->logo0->name ?>" id="Startup-profile-img" alt="asdasd" />
	
	<div class="profile-name">
		<?php
			$this->widget('bootstrap.widgets.TbEditableField', array(
				'type'      => 'text',
				'model'     => $model,
				'attribute' => 'name',
				'url'       => array('update'),  //url for submit data          
				'placement' => 'right',
			 ));
			 
		?>
		
		<span class="teste" style="float:right;">
			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>'Follow',
				'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'normal', // null, 'large', 'small' or 'mini'
				'url'=>array(''),
				)); 
			?>
		
		</span>
	</div>



	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>'Voltar',
		'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		'size'=>'small', // null, 'large', 'small' or 'mini'
		'url'=>array('view','name'=>$model->name),
	)); ?>
	
	<!-- !!!!!!!!!!!!!! image form !!!!!!!!!!!!!!!!-->
	
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'image-edit-form',
		'type'=>'horizontal',
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data'),
	)); 
	?>
	
	
	<?php echo $form->fileFieldRow($model, 'pic', array('labelOptions' => array('label' => ''))); ?>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
			'size'=>'normal',
			)); 
	?>
	
	
	<?php $this->endWidget(); ?>

</div>
	



<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-cogs profile-icon"></i> Video<span style="display:block; font-size:13px; font-style: italic;  color:#aaa;">Link para video do youtube</span></div>
		
		<div class="content-info">
			<div class="chonga">
				<p>	<?php $this->widget('editable.EditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'video',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-large',
					 )); ?>  
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head"><i class="icon-cogs profile-icon"></i> Imagens</div>
		
		<div class="content-info">
			
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'mult-image-edit-form',
				'htmlOptions' => array('enctype' => 'multipart/form-data'), 
			)); ?>
			
			<?php
				$this->widget('CMultiFileUpload', array(
					'model'=>$model,
					'name'=>'mult_pic',
					'accept' => 'jpeg|jpg|gif|png',
					'max'=>4-count($model->images),
					// useful for verifying files
					//'duplicate' => 'Arquivo duplicado!', // useful, i think
					'denied' => '', // useful, i think
				));
			?>
			
			
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Upload',
					'size'=>'normal',
					)); 
			?>
	
	
	<?php $this->endWidget(); ?>
			
			<div class="mult-pic-preview"></div>
			
			
			
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head">Sector and Location</div>
		
		<div class="content-info">
			<p> <?php echo '<b>Sector: </b>'; ?>    
				<?php $this->widget('bootstrap.widgets.TbEditableField', array(
					'type'      => 'select',
					'model'     => $model,
					'attribute' => 'sector',
					'url'       => array('update'),
					'source'    => CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'), 			
					'placement' => 'right',
				 )); ?>  
			</p>
			
			<div class="sectors_wrap">
				<?php $this->renderPartial('_sectors', array('model'=>$model)); ?>
			</div>
			
			
			
		<div class="profile-sectors">
			<span>
                <?php           
                $this->widget('editable.Editable', array(
                    'type'      => 'select2',
                    'name'      => 'sector',
                    'pk'        => $model->id,
                    'url'       => $this->createUrl('updateSectors'), 
                    'source'    => CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'),
                    'text'      => $model->getSectorCommaNames(),  
                    'value'     => $model->getSectorIds(),
                    'placement' => 'right',
                    'inputclass'=> 'input-large',
                    'select2'   => array(
                        'placeholder'=> 'Select...',
                        'multiple'=>true,
						'maximumSelectionSize'=> 3,
                    ),
                )); ?>
            </span>
		</div>
			
			
			
			
			<p> <?php echo '<b>Post Code: </b>'; ?>    
				<?php $this->widget('bootstrap.widgets.TbEditableField', array(
					'type'      => 'text',
					'model'     => $model,
					'attribute' => 'post_code',
					'url'       => array('update'),  
					'placement' => 'right',
				 )); ?>  
			</p>
			
			<p> <?php echo '<b>Cityaaaa: </b>'; ?>    
                <?php           
                $this->widget('editable.EditableField', array(
                    'type'      => 'select2',
                    'model'     => $model,
                    'attribute' => 'location',
                    'url'       => $this->createUrl('updateLocation'), 
                    'source'    => Cidade::model()->getCities(),
                    'placement' => 'right',
                    'inputclass'=> 'input-large',
                    'select2'   => array(
                        'placeholder'=> 'Select...',
                        'allowClear'=> true,   
                        'dropdownAutoWidth'=> true,
                        'minimumInputLength'=> 3,
                    )
                )); ?> 
            </p>
			
			
		</div>
		
	</div>	

	<div class="content-wrap">

		<div class="content-head">Company</div>
		
		<div class="content-info">
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
					'source'    => $model->getCompanySizeOptions(), 
					'placement' => 'right',
				 )); ?> 
			</p>
			
			<p> <?php echo '<b>Company Stage: </b>'; ?>    
				<?php $this->widget('bootstrap.widgets.TbEditableField', array(
					'type'      => 'select',
					'model'     => $model,
					'attribute' => 'company_stage',
					'url'       => array('update'),  
					'source'    => $model->getCompanyStageOptions(), 
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
			
			<p> <?php echo '<b>Company Number: </b>'; ?>    
				<?php $this->widget('bootstrap.widgets.TbEditableField', array(
					'type'      => 'text',
					'model'     => $model,
					'attribute' => 'company_number',
					'url'       => array('update'),  
					'placement' => 'right',
				 )); ?>  
			</p>
		 
		</div>
		
	</div>	

</div>

<div class="profile-column-r">


	<div class="content-wrap">

		<div class="content-head">Typeahead Role</div>
		
		<div class="content-info">

		
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'form-chonga',
				'action'=>' ',
				'htmlOptions' => array('enctype' => 'multipart/form-data'), 
			)); ?>
	
	
				<input type="text" id="my_ac" size="40" />
				<input type="hidden" id="my_ac_id" name="user_chonga"/>
				
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Chonga',
					'size'=>'normal',
					)); 
				?>
				
				<?php echo CHtml::activeDropDownList($model,'user_role', array_merge(array(''=>'Selecione...'), CHtml::listData(Role::model()->findAll(), 'role_id', 'name')), array('name'=>'role')) ?>
		
			<?php $this->endWidget(); ?>

			<script>
				$(function() {

    $("#my_ac").autocomplete({
        source: <?php $model->getAutoTest(); ?>,
        minLength: 0,
		delay: 10,
		select: function( event, ui ) {
			$( "#my_ac" ).val( ui.item.label );
			$( "#my_ac_id" ).val( ui.item.value );
			return false;
      }
    }).data( "uiAutocomplete" )._renderItem = function( ul, item ) {
        var inner_html = '<a><div class="list_item_container"><div class="image"><img src="' + item.image + '"></div><div class="label">' + item.label + '</div><div class="description">' + item.description + '</div></div></a>';
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
});
			</script>
		
		</div>	
	</div>




<div class="content-wrap">

		<div class="content-head">Users</div>
		
		<div class="content-info crazy">

		

			

		
		</div>	
	</div>


	
	<div class="content-wrap">

		<div class="content-head">Links</div>
		
		<div class="content-info">
			<p> <?php echo '<b>Website: </b>'; ?>    
				<?php $this->widget('editable.EditableField', array(
					'type'      => 'text',
					'model'     => $model,
					'attribute' => 'website',
					'url'       => array('update'),  
					'placement' => 'right',
					'inputclass'=> 'input-large',
				 )); ?>  
			</p>
			
			<p> <?php echo '<b>Facebook: </b>'; ?>    
				<?php $this->widget('bootstrap.widgets.TbEditableField', array(
					'type'      => 'text',
					'model'     => $model,
					'attribute' => 'facebook',
					'url'       => array('update'),  
					'placement' => 'right',
				 )); ?>  
			</p>
			
			<p> <?php echo '<b>Twitter: </b>'; ?>    
				<?php $this->widget('bootstrap.widgets.TbEditableField', array(
					'type'      => 'text',
					'model'     => $model,
					'attribute' => 'twitter',
					'url'       => array('update'),  
					'placement' => 'right',
				 )); ?>  
			</p>
			
			<p> <?php echo '<b>linkedin: </b>'; ?>    
				<?php $this->widget('bootstrap.widgets.TbEditableField', array(
					'type'      => 'text',
					'model'     => $model,
					'attribute' => 'linkedin',
					'url'       => array('update'),  
					'placement' => 'right',
				 )); ?>  
			</p>
		
		</div>
		
	</div>	

	<div class="content-wrap">

		<div class="content-head">Private Profile!!!!!!!!!!! - Business Model</div>
		
		<div class="content-info">
		<p> <?php echo '<b>Client Segment: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'client_segment',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	<p> <?php echo '<b>Value Proposition: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'value_proposition',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	<p> <?php echo '<b>Market Size: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'market_size',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	<p> <?php echo '<b>Sales/Marketing Proposition: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'sales_marketing',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	<p> <?php echo '<b>Revenue Generation: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'revenue_generation',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	<p> <?php echo '<b>Competitors: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'competitors',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
	
	<p> <?php echo '<b>Competitive Advantage: </b>'; ?>    
        <?php $this->widget('bootstrap.widgets.TbEditableField', array(
            'type'      => 'text',
            'model'     => $model,
            'attribute' => 'competitive_advantage',
            'url'       => array('update'),  
            'placement' => 'right',
         )); ?>  
    </p>
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head">Header</div>
		
		<div class="content-info">
		Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum 
		</div>
		
	</div>	

</div>
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

	<b><?php echo CHtml::encode($model->getAttributeLabel('linkedin')); ?>:</b>
	<?php echo CHtml::encode($model->linkedin); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('location')); ?>:</b>
	<?php echo CHtml::encode($model->location); ?>
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
	 

