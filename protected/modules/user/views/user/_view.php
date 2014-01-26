
<div class="view-list">

    <div class="startup-view-img">
        <?php echo CHtml::link('<img src="'.'http://'.S3::BUCKET_NB.'.s3.amazonaws.com/'.$data->logo->name.'" />', array('/' . $data->user->username)); ?>
    </div>
    
    <div class="view-list-text">
    
        <?php echo CHtml::link(CHtml::encode($data->user->getFullName()),array('/' . $data->user->username), array('class'=>'startup-view-name'));?>

        <div class="profile-view-pitch" >
            <?php echo CHtml::encode($data->resume); ?>
        </div>
        <?php if (isset($data->city)): ?>
        <div class="startup-view-location">
			<i class="icon-map-marker"></i><a href="<?php echo Yii::app()->baseUrl.'/user?g=&c='.$data->city->id; ?>"><?php echo $data->city->nome; ?></a> 		
		</div>
        <?php endif; ?>

        <div class="profile-view-role">	
            <?php echo $data->user->getRolesForPrint() ?>
        </div>
    </div>
       
        
    
    
    <div class="follow-count" data-name="<?php echo $data->user->username; ?>"><?php echo count($data->user->followers); ?></div> 
    
    <?php if(Yii::app()->user->checkAccess('followUser', array('userid'=>$data->user_id))): ?>
    
        <span class="follow-btn">    
            <?php 
            if(!$data->user->hasUserFollowing(Yii::app()->user->id))
            {
                $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>UserModule::t('Follow'),
                'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'mini', // null, 'large', 'small' or 'mini'
                'url'=>'',//array('follow','name'=>$model->name),
                'htmlOptions'=>array('class'=>'btn-follow follow-press'),
                )); 
            }
            else
            {
                $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>UserModule::t('Unfollow'),
                'size'=>'mini', // null, 'large', 'small' or 'mini'
                'url'=>'',//array('unfollow','name'=>$model->name),
                'htmlOptions'=>array('class'=>'btn-unfollow follow-press'),
                )); 
            }
            ?>        
        </span>
        
    
    <?php endif ?>
    
    <?php if($data->user->isUserInRole("Founder")): ?>
        <div class="founder" data-id="<?php echo $data->user_id; ?>" data-toggle='tooltip' data-html=true data-original-title='FUNDADOR'>
            <img src="<?php echo Yii::app()->request->baseUrl.'/images/founder-icon-small.png'; ?>" data-toggle="modal" data-target="#modal-<?php echo $data->user_id ?>">
            
            <?php $this->beginWidget(
                'bootstrap.widgets.TbModal',
                array('id' => 'modal-'.$data->user_id)
            ); ?>
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">&times;</a>
                    <h4 class="modal-title" id="myModalLabel">Startups do <?php echo $data->firstname .' '. $data->lastname ?></h4>
                </div>

                <div class="modal-body">
                   
                </div>

                <div class="modal-footer">

                    <?php $this->widget(
                        'bootstrap.widgets.TbButton',
                        array(
                            'label' => 'Close',
                            'url' => '#',
                            'htmlOptions' => array('data-dismiss' => 'modal'),
                        )
                    ); ?>
                </div>

            <?php $this->endWidget(); ?>

                         
        </div>
    <?php endif ?>
    
</div>

