<div class="carousel-home-item">
	
	<div class="top-item">
		
		<div class="startup-view-img">
			<?php echo CHtml::link('<img src="'.Yii::app()->request->baseUrl.'/images/'.$data->logo0->name.'"/>', array('startup/view', 'name'=>$data->startupname)); //id="Startup-list-img"?>
		</div>
		
		<div class="item-name">
			<?php echo CHtml::link(CHtml::encode($data->name),array('startup/view','name'=>$data->startupname));?>
		</div>
		
	</div>
	
	<div class="bottom-item">
	
		<div class="item-pitch">
			<?php echo CHtml::encode($data->one_line_pitch); ?>
		</div>
		
		<div class="middle-item">
		
			<div class="item-info">
				<div class="item-info-sub"><span style="color:#676767;">FUNDADOR</span>
					<div style="float:right; font-size:13px; color:black;">
					
					<?php $relational_tbl=UserStartup::model()->find('startup_id=:s_id AND position=:pos', array(':s_id'=>$data->id, ':pos'=>'Founder')); ?>
					<?php if($relational_tbl):?>
						<?php $usr=User::model()->findbyPk($relational_tbl->user_id);?>
						<?php echo $usr->profile->firstname .' '. $usr->profile->lastname;?>
					<?php endif;?>
					
					</div>
				</div>
				
				<div class="item-info-sub"><span style="color:#676767;">ESTÁGIO</span>
					<div style="float:right; width:100px; height:15px;">
						<?php
					
						if($data->company_stage=='Conceito')
						{
							$this->widget('bootstrap.widgets.TbProgress', array(
								'percent'=>25, // the progress
								'striped'=>true,
								'animated'=>true,
								'type'=>'danger',
								'htmlOptions'=>array('style'=>'margin:0; height:15px;'),
							));
							//echo '<br /><b>Stage 1:</b> Conceito';
						}
						
						else if($data->company_stage=='Desenvolvimento')
						{
							$this->widget('bootstrap.widgets.TbProgress', array(
								'percent'=>50, // the progress
								'striped'=>true,
								'animated'=>true,
								'type'=>'warning',
								'htmlOptions'=>array('style'=>'margin:0; height:15px;'),
							));
							//echo '<br /><b>Stage 2:</b> Desenvolvimento';
						}
						
						else if($data->company_stage=='Protótipo')
						{	
							$this->widget('bootstrap.widgets.TbProgress', array(
								'percent'=>75, // the progress
								'striped'=>true,
								'animated'=>true,
								'htmlOptions'=>array('style'=>'margin:0; height:15px;'),
							));
							//echo '<br /><b>Stage 3:</b> Protótipo';
						}
						
						else if($data->company_stage=='Produto Final')
						{	
							$this->widget('bootstrap.widgets.TbProgress', array(
								'percent'=>100, // the progress
								'striped'=>true,
								'animated'=>true,
								'type'=>'success',
								'htmlOptions'=>array('style'=>'margin:0; height:15px;'),
							));
							//echo '<br /><b>Stage 4:</b> GProduto Final';
						}
						?>
					
					</div>
				</div>
			</div>
			
			<div class="item-sec">
				<?php echo Startup::model()->findByPk($data->id)->getSectorNames(); ?>
			</div>
		</div>
		
		<div class="item-location">
			<i class="icon-map-marker profile-icon"></i><?php if (isset($data->city)) echo $data->city->nome; ?>
		</div>
	</div>
</div>