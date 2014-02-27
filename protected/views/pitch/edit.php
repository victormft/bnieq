<?php $this->pageTitle='Pitch - '.CHtml::encode($model->startup->name); ?>

<?php

$this->layout='column1';

//$p_product = empty($model->product_description) ? 1 : 0;

//$p_stage = empty($model->company_stage) ? 1 : 0;

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/charCount.js', CClientScript::POS_END);


Yii::app()->clientScript->registerScript('loading-img',
"	
	
	$(document).ready(function(){ 
	
		window.addEventListener('scroll',navbar_reset_top,false);
		
		
		
		
		if($('.alert-error').length)
		{
			$('.err-publish').css({'display':'inline'});
		}
	});
	
	
	function readURL(input) {

		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#startup-profile-img').css({'background-image':'url('+e.target.result +')'});
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	
	
	
	$('.editable-wrap').on('click','.editable-submit', function(event){
		if($(this).parents().eq(7).hasClass('editable-wrap'))
		{
			var elem = $(this).parents().eq(6).find('a');
			if(elem.hasClass('editable-empty'))
				var wasempty = 1;
			else
				var wasempty = 0;
			
			setTimeout(function(){
				
				if(!elem.hasClass('editable-open'))
				{			
					if(!elem.hasClass('editable-empty') && wasempty)
						checkCompletionBar(0.04);
					else if(elem.hasClass('editable-empty') && !wasempty)
						checkCompletionBar(-0.04);
				}
			}, 1000);
		}
	});



	$('.nav li:contains(\"Home\")').addClass('xuxu');
	
	$('.profile-editable-content').mouseover(function(event) {
		$(this).find('.pic-btn').addClass('btn-primary').removeClass('disabled');	
	});
	
	$('.profile-editable-content').mouseout(function(event) {
		$(this).find('.pic-btn').removeClass('btn-primary').addClass('disabled');	
	});
	
	$('#startup-profile-img').mouseover(function(event) {
		$(this).css({'box-shadow': '2px 2px 4px 1px #aaa'});		
	});
	
	$('#startup-profile-img').mouseout(function(event) {
		$(this).css({'box-shadow': 'inset 0px 0px 4px 1px #ddd'});
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


function checkCompletionBar(adjust)
{
	var bar_parent = $('.bar').parent();
	bar_parent.removeClass('progress-danger').removeClass('progress-warning').removeClass('progress-success');
	
	var width = $('.bar').width();
	var parentWidth = $('.bar').parent().width();
	var percent = width/parentWidth;
	percent=percent+adjust;
	var new_width=parentWidth*percent;
	percent=Math.round(percent*100);
	
	$('.bar').css({'width':new_width});
	$('.completion-percent').html(percent+'%');
	
	if(percent<=40)
			bar_parent.addClass('progress-danger');
		else if(percent>40 && percent<75)
			bar_parent.addClass('progress-warning');
		else
			bar_parent.addClass('progress-success');
}

function navbar_reset_top() 
{
	var navbar_top=62;
	var elem=$('.completion-bar');
	var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
	if(scrollTop>navbar_top && elem.hasClass('bar-absolute')) {
		elem.removeClass('bar-absolute').addClass('bar-fixed');
	}
	else if(scrollTop<navbar_top && elem.hasClass('bar-fixed')) {
		elem.removeClass('bar-fixed').addClass('bar-absolute');
	}
}

	$('.editable-wrap').on('keyup','.input-xlarge',function(){
			maxLen=1000;
			$(this).closest('.editable-wrap').find('.counter').html(maxLen - this.value.length+' Caracteres Restantes');
	});
	
");

?>

<div class="completion-bar bar-absolute" style="z-index:999;">
	<div class="pull-left" style="margin-left: 80px">
        <span style="float:left; margin-right: 20px; font-size:24px;">Edit Pitch: <i><b><?php echo $model->startup->name ?></b></i></span>
        
    </div>
    <div class="pull-right" style="margin-right: 80px">
        <span style="float:left; margin-right: 20px; font-size:24px;">Status:</span>
        <?php

            if($model->completion<=40)
                $type="danger";
            else if($model->completion>40 && $model->completion<75)
                $type="warning";
            else
                $type="success";

            echo "<div style='float:left; width: 200px; border:2px solid #ccc; border-radius:5px;'>";
            $this->widget('bootstrap.widgets.TbProgress', array(
                'percent'=>$model->completion, // the progress
                'striped'=>true,
                'animated'=>true,
                'type'=>$type,
                'htmlOptions'=>array('style'=>'margin:0;'),
            ));
            echo "</div>";
        ?>
        <span class="completion-percent" style="float:left; margin-left: 10px; font-size:24px; font-style:italic; font-weight:bold;"><?php echo $model->completion; ?>%</span>
    </div>
</div>


<div class="spacing-1" style="margin-top:50px;"></div>

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


<div class="profile-header-edit">	

	
    <div id="startup-profile-img" data-toggle='tooltip' data-original-title='Substituir Imagem' style="margin-right:30px; background-image:url(<?php echo 'http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$model->startup->logo0->name; ?>); background-size:cover; background-position: 50% 50%;"></div>
  
	
	
	<div class="profile-edit-header">
	
		
		<div class="editable-wrap profile-editable-content">
			<div class="content-info-unit">
				<div class="header-label">
					<b>Investimento pedido:</b> 
				</div>
					<span class="start-name" data-toggle='tooltip' data-original-title='Nome que aparecerá para o público' style="padding-top:5px;">
						<?php $this->widget('bootstrap.widgets.TbEditableField', array(
							'type'      => 'text',
							'model'     => $model,
							'attribute' => 'investment_required',
							'url'       => array('update'),  
							'placement' => 'right',
							'inputclass'=> 'input-large',
							'mode'=>'inline',
							'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
							'options'    => array(
								'tpl'=>'<input type="text" class="input-large" style="padding-right: 24px;" maxlength="40">'
							)
						 )); ?>  
					</span>
			</div>
			
			<div class="content-info-unit">			
				<div class="header-label">
					<b>Equity:</b> 
				</div>
					<span data-toggle='tooltip' data-original-title='Breve resumo da startup' style="padding-top:5px;">
					<?php $this->widget('bootstrap.widgets.TbEditableField', array(
						'type'      => 'text',
						'model'     => $model,
						'attribute' => 'equity',
						'url'       => array('update'),  
						'placement' => 'right',
						'inputclass'=> 'input-large',
						'mode'=>'inline',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'options'    => array(
							'tpl'=>'<input type="text" class="input-large" style="padding-right: 24px;" maxlength="80">'
						)
					 )); ?>
					</span>
			</div>
			
				
				
		</div>
	</div>
	
	<span class="teste" style="float:right;">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Publicar',
            'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size'=>'normal', // null, 'large', 'small' or 'mini'
            'url'=>array('publish','name'=>CHtml::encode($model->startup->startupname)),
            )); 
        ?>		
		
    </span>
	


</div>
	



<div class="profile-column-l">
		
	
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-youtube-play profile-icon"></i> Video
			<span class="tip">Link para video do youtube - pode ser o mesmo da sua startup ou não</span>
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
						'emptytext' => 'Vazio',
						'mode'=>'inline',
						'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
					 )); ?>  
				</p>
			</div>
			
		</div>
		
	</div>	
	
	
    
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-lightbulb profile-icon"></i>Pitch Text
			<div class="err-publish err-product" style="display:none; margin-left:30px; color:#b94a48; font-size:15px; font-weight:normal; letter-spacing:0;"><?php //if(!$model->product_description) echo UserModule::t("Required"); ?></div>
			<span class="tip">Para que você quer esse investimento?</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap">
				<span class="start-product">
					<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
							'type'      => 'textarea',
							'model'     => $model,
							'attribute' => 'pitch_text',
							'url'       => array('update'),  
							'placement' => 'right',
							'inputclass'=> 'input-xlarge',
							'emptytext' => 'Vazio',
							'mode'=>'inline',
							'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
							'options'    => array(
								'tpl'=>'<textarea class="input-xlarge" rows="7" maxlength="1000"></textarea>'
							)
						 )); ?>  
									
					</p>
				</span>
				<span class="counter"></span>
			</div>
			
		</div>
		
	</div>	
    
    
    
    
	<div class="content-wrap">

		<div class="content-head rounded">
			<i class="icon-lightbulb profile-icon"></i>Exit Strategy
			<div class="err-publish err-product" style="display:none; margin-left:30px; color:#b94a48; font-size:15px; font-weight:normal; letter-spacing:0;"><?php //if(!$model->product_description) echo UserModule::t("Required"); ?></div>
			<span class="tip">Quais as estratégias para pagar os investidores?</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap">
				<span class="pitch-exit">
					<p>	<?php $this->widget('bootstrap.widgets.TbEditableField', array(
							'type'      => 'textarea',
							'model'     => $model,
							'attribute' => 'exit_strategy',
							'url'       => array('update'),  
							'placement' => 'right',
							'inputclass'=> 'input-xlarge',
							'emptytext' => 'Vazio',
							'mode'=>'inline',
							'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
							'options'    => array(
								'tpl'=>'<textarea class="input-xlarge" rows="7" maxlength="1000"></textarea>'
							)
						 )); ?>  
									
					</p>
				</span>
				<span class="counter"></span>
			</div>
			
		</div>
		
	</div>
</div>
	
	
    
    
<!-- DEPOIS COLOCA O LADO DIREITO -->
<div class="profile-column-r">
	
	
</div>

