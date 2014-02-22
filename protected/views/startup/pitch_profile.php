<?php
$this->layout='column1';
?>




<div class="profile-header-wrap">
	<div class="profile-header">	
		<div id="startup-profile-img" style="background-image:url(<?php echo 'http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$model->logo0->name; ?>); background-size:cover; background-position: 50% 50%;"></div>
		
		<div class="profile-header-info">
			
			<div class="profile-name">
				<span><?php echo CHtml::encode($model->name); ?></span>
			</div>
			
			<div class="profile-onelinepitch">
				<span style="font-style:italic;"><?php echo CHtml::encode($model->one_line_pitch); ?></span>
			</div>
			
			<div class="profile-sectors">
				<span><?php echo $model->getSectorNames(); ?></span>
			</div>
			
			<div class="profile-location">
				<i class="icon-map-marker profile-icon"></i><?php if (isset($model->city)) echo CHtml::encode($model->city->nome); ?>
			</div>
		</div>
        
        <div class="profile-header-right pitch-profile" style='position: absolute; top: 0; right: 0; width: 300px; border-left: 2px dotted #d4d4d4'>
            <div class="profile-name" style='text-align: center; margin-top: 35px;'>
				Perfil de captação
			</div>
            <h3 style='text-align: center'>Status: 
                <?php if($profile->complete == true) echo '<span class="badge badge-success" style="padding: 6px 8px; font-size: 17px;">Aprovado</span></h3>';
                else echo '<span class="badge badge-warning" style="padding: 6px 8px; font-size: 17px;">Incompleto</span></h3>';
                ?>
                
        </div>
		
		
		
	</div>
	
	<div class="profile-column-l-chooser">
		<ul>
			<li class="chooser info" style="width: auto;">
				<a href="<?php echo $this->createUrl('/'.$model->startupname) ?>">Perfil Público</a>
			</li>
            <li class="chooser activity clicked" style="width: auto;">
				<a href="<?php echo $this->createUrl('/startup/pitchprofile', array('name'=>$model->startupname)) ?>">Perfil de captação</a>
			</li>
		</ul>
		
	</div>
	
</div>
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head">
			<span class="txt"><i class="icon-lightbulb profile-icon"></i>Informações</span>
			<span class="tip">Informações necessárias para que sua Startup esteja apta a captar investimento</span>
		</div>
		
		<div class="content-info">
            <?php if(Yii::app()->user->hasFlash('success')):?>
            <div class="successMessage">
            <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
            <?php endif; ?>
            
			<?php
            $form = $this->beginWidget(
                'bootstrap.widgets.TbActiveForm',
                array(
                    'id' => 'pitchProfile-form',
                    'type' => 'horizontal',
                    'htmlOptions' => array('style' => 'margin-bottom: 0'), 
                )
            );

            echo $form->textFieldRow($profile, 'cnpj', array('class' => 'span3'));
            echo $form->textFieldRow($profile, 'full_address', array('class' => 'span3'));
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

<div class="profile-column-r">
    
    <?php if($model->isUserEditor(Yii::app()->user->id)): ?>
        <div class="content-wrap">

            <div class="content-head clicked">
                <i class="icon-circle-arrow-up profile-icon"></i> Captar investimento (Pitch)
            </div>

            <div class="content-info">

                <div class="content-info-unit" style="text-align: center; overflow: hidden;">        
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'label'=>'Create Pitch',
                            'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                            'size'=>'large', // null, 'large', 'small' or 'mini'
                            'url'=>$this->createUrl('/pitch/create?startupId='.$model->id),//array('unfollow','name'=>$model->name),
                        )); ?>	 
                </div>
                

            </div>
            
        </div>  
    
    <?php endif;?>
    
	
	<?php if($model->company_stage):?>
	<div class="content-wrap" style="position:relative;">

		<div class="content-head">
			<i class="icon-signal profile-icon"></i> Estágio
			<span class="tip">Nível de evolução do nosso Produto</span>
			<!--
			<div style="width:150px; background-color:#bbb; border-radius: 5px; position:absolute; top:10px; right:30px; padding:10px;">
				<?php
			/*
				if($model->company_stage=='Conceito')
				{
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>25, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'danger',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				
				else if($model->company_stage=='Desenvolvimento')
				{
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>50, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'warning',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				
				else if($model->company_stage=='Protótipo')
				{	
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>75, // the progress
						'striped'=>true,
						'animated'=>true,
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				
				else if($model->company_stage=='Produto Final')
				{	
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>100, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'success',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					
				}
				*/
				?>
				
			</div>
			-->
		</div>
		
		<div class="content-info" style="text-align:center; overflow:visible;">
		
			<?php
			
				if($model->company_stage=='Concept')
				{
					echo "<div style='padding:15px; background:#ccc; border-radius:5px;' data-toggle='tooltip' data-html=true data-original-title='<b>Estágio 1:</b> Conceito'>";
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>25, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'danger',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo "</div>";
					//echo '<br /><b>Stage 1:</b> Conceito';
				}
				
				else if($model->company_stage=='Development')
				{
					echo "<div style='padding:15px; background:#ccc; border-radius:5px;' data-toggle='tooltip' data-html=true data-original-title='<b>Estágio 2:</b> Desenvolvimento'>";
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>50, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'warning',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo "</div>";
					//echo '<br /><b>Stage 2:</b> Desenvolvimento';
				}
				
				else if($model->company_stage=='Prototype')
				{	
					echo "<div style='padding:15px; background:#ccc; border-radius:5px;' data-toggle='tooltip' data-html=true title='<b>Estágio 3:</b> Protótipo'>";
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>75, // the progress
						'striped'=>true,
						'animated'=>true,
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo "</div>";
					//echo '<br /><b>Stage 3:</b> Protótipo';
				}
				
				else if($model->company_stage=='Final Product')
				{	
					echo "<div style='padding:15px; background:#ccc; border-radius:5px;' data-toggle='tooltip' data-html=true data-original-title='<b>Estágio 4:</b> Produto Final'>";
					$this->widget('bootstrap.widgets.TbProgress', array(
						'percent'=>100, // the progress
						'striped'=>true,
						'animated'=>true,
						'type'=>'success',
						'htmlOptions'=>array('style'=>'margin:0;'),
					));
					echo "</div>";
					//echo '<br /><b>Stage 4:</b> GProduto Final';
				}
			?>
			
		
		</div>
		
	</div>	
	<?php endif;?>
	
	
	<?php if($model->foundation):?>
	<div class="content-wrap">

		<div class="content-head">
			<i class="icon-calendar profile-icon"></i> Início da Empresa
			<span class="tip">Data em que a empresa foi criada</span>
		</div>
		
		<div class="content-info">
			
			<?php echo date('d/m/y', strtotime(CHtml::encode($model->foundation))); ?>
			
		</div>
		
	</div>
	<?php endif;?>

	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos AND approved=1', array(':s_id'=>$model->id, ':pos'=>'Founder'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Fundadores</div>
			
			<div class="content-info team-ready">
			
			<?php if(Yii::app()->user->isGuest): ?>
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			<?php else: ?>	
				
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image" style="background-image:url(<?php echo 'http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$usr_startup->profile->logo->name ?>); background-size:cover; background-position: 50% 50%;"></div>
					<div class="team-text">
						<div class="team-name"><span data-id="<?php echo CHtml::encode($usr_startup->id); ?>"><?php echo CHtml::link(CHtml::encode($usr_startup->profile->firstname .' '. $usr_startup->profile->lastname),array('/'.CHtml::encode($usr_startup->username)));?></span></div>
						<div class="team-position"><?php echo CHtml::encode(UserModule::t($rel->position));?></div>
						<div class="team-resume"><?php echo CHtml::encode($usr_startup->profile->resume);?></div>
					</div>
				</div>
				<?php endforeach;?>
			<?php endif;?>															
			</div>
			
		</div>	
	<?php endif;  ?>
	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos AND approved=1', array(':s_id'=>$model->id, ':pos'=>'Member'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Time</div>
			
			<div class="content-info team-ready">
				
			<?php if(Yii::app()->user->isGuest): ?>
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			<?php else: ?>
				
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
					<div class="team-text">
						<div class="team-name"><span data-id="<?php echo CHtml::encode($usr_startup->id); ?>"><?php echo CHtml::link(CHtml::encode($usr_startup->profile->firstname .' '. $usr_startup->profile->lastname),array('/'.CHtml::encode($usr_startup->username)));?></span></div>
						<div class="team-position"><?php echo CHtml::encode(UserModule::t($rel->position));?></div>
						<div class="team-resume"><?php echo CHtml::encode($usr_startup->profile->resume);?></div>
					</div>
				</div>
				<?php endforeach;?>
			
			<?php endif;?>
			</div>
			
		</div>	
	<?php endif;  ?>
	
	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos AND approved=1', array(':s_id'=>$model->id, ':pos'=>'Advisor'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Conselheiros</div>
			
			<div class="content-info team-ready">
				
			<?php if(Yii::app()->user->isGuest): ?>
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			<?php else: ?>
			
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
					<div class="team-text">
						<div class="team-name"><span data-id="<?php echo CHtml::encode($usr_startup->id); ?>"><?php echo CHtml::link(CHtml::encode($usr_startup->profile->firstname .' '. $usr_startup->profile->lastname),array('/'.CHtml::encode($usr_startup->username)));?></span></div>
						<div class="team-position"><?php echo CHtml::encode(UserModule::t($rel->position));?></div>
						<div class="team-resume"><?php echo CHtml::encode($usr_startup->profile->resume);?></div>
					</div>
				</div>
				<?php endforeach;?>
			
			<?php endif;?>
			</div>
			
		</div>	
	<?php endif;  ?>
	
	<?php if($relational_tbl=UserStartup::model()->findAll('startup_id=:s_id AND position=:pos AND approved=1', array(':s_id'=>$model->id, ':pos'=>'Investor'))):?>
		<div class="content-wrap">

			<div class="content-head"><i class="icon-group profile-icon"></i> Investidores</div>
			
			<div class="content-info team-ready">
				
			<?php if(Yii::app()->user->isGuest): ?>
				<p style="text-align:center;">Você precisa estar logado para ver essa Informação</p>
				<p style="text-align:center;">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'label'=>'Login',
					'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
					'size'=>'normal', // null, 'large', 'small' or 'mini'
					'url'=>array('/user/login'),
					)); 
				?>
				</p>
			<?php else: ?>
				
				<?php foreach($relational_tbl as $rel):?>
				<?php  $usr_startup=User::model()->find('id=:id', array(':id'=>$rel->user_id)); ?>
				<div class="team-item">		
					<div class="team-image"><img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$usr_startup->profile->logo->name ?>" id="team-img"/></div>
					<div class="team-text">
						<div class="team-name"><span data-id="<?php echo CHtml::encode($usr_startup->id); ?>"><?php echo CHtml::link(CHtml::encode($usr_startup->profile->firstname .' '. $usr_startup->profile->lastname),array('/'.CHtml::encode($usr_startup->username)));?></span></div>
						<div class="team-position"><?php echo CHtml::encode(UserModule::t($rel->position));?></div>
						<div class="team-resume"><?php echo CHtml::encode($usr_startup->profile->resume);?></div>
					</div>
				</div>
				<?php endforeach;?>
			
			<?php endif;?>
			</div>
			
		</div>	
	<?php endif;  ?>
		

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
	 

