<?php



Yii::app()->clientScript->registerScript('loading-img',
"	
	
	$('.team-ready').on('mouseover','.team-item',function(event){
		$(this).find('.team-delete').css({'color':'red', 'font-size':'22px'});	
	});
	
	$('.team-ready').on('mouseout','.team-item',function(event){
		$(this).find('.team-delete').css({'color':'#ccc', 'font-size':'15px'});	
	});
	
	$('.nav li:contains(\"Home\")').addClass('xuxu');
	
	$('.profile-editable-content').mouseover(function(event) {
		$(this).find('.pic-btn').addClass('btn-primary');	
	});
	
	$('.profile-editable-content').mouseout(function(event) {
		$(this).find('.pic-btn').removeClass('btn-primary');	
	});
	
	$('.team').mouseover(function(event) {
		$(this).css('color','#333');
		$('.team-btn').addClass('btn-primary');	
	});
	
	$('.team').mouseout(function(event) {
		$(this).css('color','#aaa');
		$('.team-btn').removeClass('btn-primary');	
	});
	
	$('.arrow-container').mouseover(function(event){
		$(this).css('background-color', '#fefefe');
	});
	
	$('.arrow-container').mouseout(function(event){
		$(this).css('background-color', '#f6f6f6');
	});
	
	$('.content-head').click(function(event){
		
		if(!$(this).hasClass('clicked'))
		{
			$(this).removeClass('rounded');
			$(this).next().slideDown();
			$(this).addClass('clicked');
			$(this).find('.arrow').removeClass('arrow-down');
			$(this).find('.arrow').addClass('arrow-up');
		}
		
		else
		{
			$(this).next().slideUp(function(){
				$(this).prev().addClass('rounded');
			});
			$(this).removeClass('clicked');
			$(this).find('.arrow').removeClass('arrow-up');
			$(this).find('.arrow').addClass('arrow-down');
			
		}
		
	});

	
	$('#form-team').submit(function(event) {
		
		event.preventDefault(); 
		$('.team-btn').html('<img src=\"".Yii::app()->request->baseUrl."/images/loading.gif\">');
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/addTeam?name='+getUrlVars()['name'],
				dataType: 'json',
				type: 'POST',
				data: $('#form-team').serialize(),
				success: function(data){
					$('.team-ready').append(data.res);
					$('.team-item').show('slow').animate({opacity: 1}, 250);	
					$('.team-btn').text('Save')
				}
			});
		
		
	});
	
	
	$('.team-ready').on('click','.team-delete',function(event){
		var id = $(this).parent().find('span').attr('data-id');
		$(this).parent().addClass('deletable');
		
		$.ajax({
				url: '".Yii::app()->request->baseUrl."/startup/deleteTeam?id='+id+'&name='+getUrlVars()['name'],
				dataType: 'json',
				success: function(data){
					$('.deletable').animate({opacity: 0}, 100).hide('slow', function(){ $('.deletable').remove(); });
					
				},
				error: function(){
					$('.deletable').removeClass('deletable');	
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

<div class="spacing-1"></div>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true,
    'fade' => true,
    'closeText' => '&times;', // false equals no close link
    'events' => array(),
    'htmlOptions' => array(),
    'userComponentId' => 'user',
    'alerts' => array( // configurations per alert type
        // success, info, warning, error or danger
        
        'error' => array('block' => false, 'closeText' => '&times;'),
		'warning' => array('block' => false, 'closeText' => false),
    ),
));?>

<div class="profile-header">	

	<div id="startup-profile-img">
		<img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$model->logo0->name ?>"/>
	</div>
	
	<div class="profile-edit-header">
	
		
		<div class="editable-wrap profile-editable-content">
			<div class="content-info-unit">
				<div class="header-label">
					<b>Nome:</b> 
				</div>
					<span class="macaco">
					<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'name',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-large',
						'mode'=>'inline'
					 )); ?>  
					 </span>
			</div>
			
			<div class="content-info-unit">			
				<div class="header-label">
					<b>Pitch de uma linha:</b> 
				</div>
					<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'one_line_pitch',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-large',
						'mode'=>'inline'
					 )); ?>  
			</div>
			
			<div class="content-info-unit">			
				<div class="header-label">
					<b>Setor(es):</b> 
				</div>
					<?php           
					$this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'select2',
						'model'     => $model,
						'attribute' => 'sec',
						'url'       => $this->createUrl('updateSectors'), 
						'source'    => CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'),
						'text'      => $model->getSectorCommaNames(),  
						'value'     => $model->getSectorCommaIds(),
						'placement' => 'right',
						'inputclass'=> 'input-large',
						'emptytext' => 'Vazio',
						'options' => array(
							'value'=>$model->getSectorIds(),
						),
						'select2'   => array(
							'placeholder'=> 'Select...',
							'multiple'=>true,
							'maximumSelectionSize'=> 3,
						),
						'mode'=>'inline',
						'onHidden' => 'js: function(e, reason) {
							$("#select2-drop-mask").css("display","none");
							$("#select2-drop").css("display","none");
						}',
					)); ?>
			</div>
				
			<div class="content-info-unit">			
				<div class="header-label">
					<b>Cidade:</b> 
				</div>
					<?php           
					$this->widget('bootstrap.widgets.TbEditableField', array(
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
						),
						'mode'=>'inline',
						'onHidden' => 'js: function(e, reason) {
							$("#select2-drop-mask").css("display","none");
							$("#select2-drop").css("display","none");
						}',
					)); ?> 
			</div>
				
			<div class="content-info-unit">			
				<div class="header-label">
					<b>Logo:</b> 
				</div>
				
				<div class="header-content">
					<!-- !!!!!!!!!!!!!! image form begin!!!!!!!!!!!!!!!!-->
		
					<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'logo-edit-form',
						'type'=>'horizontal',
						'clientOptions'=>array(
							'validateOnSubmit'=>true,
						),
						'htmlOptions' => array(
							'enctype' => 'multipart/form-data'),
					)); 
					?>
					
					<div class="pic-wrap">
						<?php echo $form->fileFieldRow($model, 'pic', array('labelOptions' => array('label' => ''))); ?>
					</div>
					
					<?php $this->widget('bootstrap.widgets.TbButton', array(
							'buttonType'=>'submit',
							'id'=>'pic-btn',
							'label'=>'Save',
							'size'=>'normal',
							'htmlOptions'=>array(
								'class'=>'pic-btn',
							),
							)); 
					?>
					
					
					<?php $this->endWidget(); ?>
					
					<!-- !!!!!!!!!!!!!! image form end !!!!!!!!!!!!!!!!-->
				</div>
					
			</div>
				
				
			</div>
	</div>
	
	<span class="teste" style="float:right;">
			
			<?php if($model->published==1):?>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Voltar',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('view','name'=>$model->startupname),
					)); 
				?>
			<?php else:?>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Publicar',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('publish','name'=>$model->startupname),
					)); 
				?>	
			<?php endif;?>
			
			
		
		</span>
	


</div>
	



<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-lightbulb profile-icon"></i>O Produto
			<span class="tip">Descreva o produto detalhadamente</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'product_description',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline',
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-youtube-play profile-icon"></i> Video
			<span class="tip">Link para video do youtube</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'video',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
				</p>
			</div>
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-picture profile-icon"></i> Imagens
			<span class="tip">Insira até 4 imagens do seu produto (500 x 312px)</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap editable-img">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'mult-image-edit-form',
					'htmlOptions' => array('enctype' => 'multipart/form-data'), 
				)); ?>
				
				<div class="pic-wrap">
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
				</div>
			
			
			
				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'label'=>'Upload',
						'size'=>'normal',
						'htmlOptions'=>array(
							'class'=>'pic-btn',
						),
						)); 
				?>
			</div>
	
	<?php $this->endWidget(); ?>
			
			<div class="mult-pic-preview"></div>
			
			
			
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-link profile-icon"></i> Website & Social
			<span class="tip">Edite os links para o Website da empresa e para as Redes Sociais</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap">
				<p> <i class="icon-globe web"></i>    
					<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'website',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
				</p>
				
				<p> <img class="social-edit-img" src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png'?>"/>     
					<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'facebook',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
				</p>
				
				<p> <img class="social-edit-img" src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png'?>"/>
					<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'twitter',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
				</p>
				
				<p> <img class="social-edit-img" src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png'?>"/>   
					<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'linkedin',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
				</p>
			</div>
		</div>
		
	</div>		
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-cogs profile-icon"></i> Tecnologia
			<span class="tip">Tecnologia utilizada no produto</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'tech',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-screenshot profile-icon"></i> Público Alvo
			<span class="tip">Pessoas ou Grupos a quem se destinam o produto</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'client_segment',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-money profile-icon"></i> Geração de Renda
			<span class="tip">Como sua Startup gera dinheiro?</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'revenue_generation',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-warning-sign profile-icon"></i> Principais Concorrentes
			<span class="tip">Outros Players que atuam na mesma área</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'competitors',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-trophy profile-icon"></i> Vantagem Competitiva
			<span class="tip">Qual o diferencial da sua empresa?</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'competitive_advantage',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-book profile-icon"></i> História da Empresa
			<span class="tip">Breve histórico da Startup</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'textarea',
						'model'     => $model,
						'attribute' => 'history',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-xlarge',
						'mode'=>'inline'
					 )); ?>  
					 			
				</p>
			</div>
			
		</div>
		
	</div>	
	
	<!--
	<div class="sectors_wrap">
		<?php //$this->renderPartial('_sectors', array('model'=>$model)); ?>
	</div>
	-->

</div>

<div class="profile-column-r">
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-signal profile-icon"></i> Estágio
			<span class="tip">Indique o Estágio de Desenvolvimento do Produto</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
			
		<div class="content-info edit">
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'select',
						'model'     => $model,
						'attribute' => 'company_stage',
						'url'       => array('update'),  
						'source'    => $model->getCompanyStageOptions(), 
						'placement' => 'right',
						'mode'=>'inline',
					 )); ?>  
									
				</p>
			</div>
				
		</div>
		
	</div>	
	
	<!--
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-building profile-icon"></i>Tamanho
			<span class="tip">Número de membros da Startup</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
			
		<div class="content-info edit">
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'select',
						'model'     => $model,
						'attribute' => 'company_size',
						'url'       => array('update'),  
						'source'    => $model->getCompanySizeOptions(), 
						'placement' => 'right',
						'mode'=>'inline',
					 )); ?>  
									
				</p>
			</div>
				
		</div>
		
	</div>	
	-->
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-calendar profile-icon"></i> Data
			<span class="tip">Indique a data de início das atividades</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
			
		<div class="content-info edit">
			<div class="editable-wrap">
				<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'date',
						'model'     => $model,
						'attribute' => 'foundation',
						'url'       => array('update'),  
						'placement' => 'right',
						'format'      => 'yyyy-mm-dd', //format in which date is expected from model and submitted to server
						'viewformat'  => 'dd/mm/yyyy', //format in which date is displayed
						'mode'=>'inline',
					 )); ?>  
									
				</p>
			</div>
				
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head" style="border-radius: 5px 5px 0 0;">
			<i class="icon-group profile-icon"></i> Equipe
			<span class="tip">Insira os usuários relacionados com a startup</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit" style="border-radius: 0;">
			
			<div class="editable-wrap team">
		
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'form-team',
					'action'=>'',
					'htmlOptions' => array('enctype' => 'multipart/form-data'), 
				)); ?>
		
					<?php echo CHtml::label('Nome', false); ?>
					<input type="text" id="my_ac" size="40" />
					<input type="hidden" id="my_ac_id" name="user_startup"/>
					
					<?php echo CHtml::label('Papel', false); ?>
					<?php echo CHtml::activeDropDownList($model,'user_role', array_merge(array(''=>'Selecione...'), $model->getCompanyPositionOptions()), array('name'=>'position')) ?>
			
					<?php $this->widget('bootstrap.widgets.TbButton', array(
						'buttonType'=>'submit',
						'label'=>'Save',
						'size'=>'normal',
						'htmlOptions'=>array(
							'style'=>'display:block',
							'class'=>'team-btn',
							),
						)); 
					?>
			
				<?php $this->endWidget(); ?>
				
			</div>
			
			<script>
				$(function() {
	
	var img_path = "<?php echo Yii::app()->request->baseUrl.'/images/'?>";
	
    $("#my_ac").autocomplete({
        source: <?php $model->getAutoTest(); ?>,
        minLength: 0,
		delay: 10,
		select: function( event, ui ) {
			$( "#my_ac" ).val( ui.item.label);
			$( "#my_ac_id" ).val( ui.item.value );
			return false;
      }
    }).data( "uiAutocomplete" )._renderItem = function( ul, item ) {
        var inner_html = '<a><div class="list_item_container"><div class="image"><img src="' + img_path + item.image + '"></div><div class="aa">' + item.label + '</div><div class="description">' + item.description + '</div></div></a>';
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append(inner_html)
            .appendTo( ul );
    };
});
			</script>
		
		</div>	
	</div>




<div class="content-wrap" style="margin-top:0px;">
		<!--
		<div class="content-head" style="border-radius: 0; border-top: none;">
			<i class="icon-group profile-icon"></i> Equipe
			<span class="tip">Equipe da Startup (edite na aba acima)</span>
		</div>
		-->
		<div class="content-info team-ready">

		
		<?php foreach($model->users1 as $usr_startup):  ?>
		
		<?php $relational_tbl=UserStartup::model()->find('user_id=:u_id AND startup_id=:s_id', array(':u_id'=>$usr_startup->id, ':s_id'=>$model->id)); ?>
		
		<div class="team-item">		
			<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
			<div class="team-name"><span data-id="<?php echo $usr_startup->id; ?>"><?php echo $usr_startup->profile->firstname . ' ' . $usr_startup->profile->lastname; ?></span></div>
			<div class="team-position"><?php echo $relational_tbl->position;?></div>
			<div class="team-resume"><?php echo $usr_startup->profile->resume;?></div>
			<div class="team-delete"><i class="icon-remove-sign"></i></div>
		</div>
		
		<?php endforeach;?>
			
		
		
		</div>	
	</div>	

</div>

