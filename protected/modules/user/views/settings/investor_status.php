<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Investor Status"); ?>

<?php Yii::app()->clientScript->registerScript('dropdowns',
"
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
");
?>



<?php $this->renderPartial('_navigation', array('active'=>'investor_status')); ?>

<div class="settings-wrap">
    <div class="span8">
        <?php if(Yii::app()->user->hasFlash('success')):?>
        <div class="successMessage">
        <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
        <?php endif; ?>

        <h1><?php echo UserModule::t("Investor Status"); ?></h1>

        <div class="content-wrap">
            <div class="content-head <?php echo $model->isFilled() ? 'clicked' : 'rounded'; ?>">
                <i class="icon-user profile-icon"></i> <span>Se você investe como pessoa física</span> <?php echo $model->isComplete() ? '<span class="badge badge-success" style="float: right; margin-right: 100px; padding: 5px 8px; font-size: 17px;">Aprovado</span>' : ''; ?>
                <div class="arrow-container"><div class="arrow <?php echo $model->isFilled() ? 'arrow-up' : 'arrow-down'; ?>" style="margin: 24px auto"></div></div>
            </div>
            
            <div class="content-info <?php echo $model->isFilled() ? '' : 'edit'; ?>">
                <div class="profile-edit-header" style="width: 100%">
                    <div class="editable-wrap-hover profile-editable-content" style="width: 675px">    

                        <div class="content-info-unit"> 
                            <?php
                            $form = $this->beginWidget(
                                'bootstrap.widgets.TbActiveForm',
                                array(
                                    'id' => 'investorProfile-form',
                                    'type' => 'horizontal',
                                    'htmlOptions' => array('style' => 'margin-bottom: 0'),
                                )
                            );

                            echo $form->textFieldRow($model, 'full_name', array('class' => 'span3'));
                            echo $form->textFieldRow($model, 'cpf', array('class' => 'span3'));
                            echo $form->textFieldRow($model, 'rg', array('class' => 'span3'));
                            ?>
                            <div class="form-actions" style="background-color: transparent; margin-bottom: 0">
                                <?php $this->widget(
                                    'bootstrap.widgets.TbButton',
                                    array(
                                        'buttonType' => 'submit',
                                        'type' => 'primary',
                                        'label' => 'Submit'
                                    )
                                ); ?>
                            </div>
                            <?php
                            $this->endWidget();
                            unset($form);
                            ?>

                        </div>
                    </div>
                </div>
            </div>
                
            
        </div>
        
        <div class="content-wrap">
            <div class="content-head rounded">
                <i class="icon-briefcase profile-icon"></i> Se você investe através de uma pessoa jurídica
                <div class="arrow-container"><div class="arrow arrow-down" style="margin: 24px auto"></div></div>
            </div>
            
            <div class="content-info edit"></div>
            
        </div>
        
    </div>
</div> 

