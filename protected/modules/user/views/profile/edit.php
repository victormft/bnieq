<?php
$this->layout='//layouts/column1';

$this->breadcrumbs=array(
	'Users'=>array('/user/user'),
	$model->getFullName(),
); 

Yii::app()->clientScript->registerScript('loading-img',
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

<div class="profile-header" style="padding-bottom: 15px;">
    
    <img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$profile->logo->name ?>" id="user-profile-img" alt=" " >    
    
	<div class="user-profile-header-info">        
        <p> <?php echo '<b>Nome: </b>';?>  
            <?php
                $this->widget('editable.EditableField', array(
                    'type'      => 'text',
                    'model'     => $profile,
                    'attribute' => 'firstname',
                    'url'       => array('updateEd'),  //url for submit data 
                    'inputclass'=> 'input-small',
                 ));
                 echo ' ';
                 $this->widget('editable.EditableField', array(
                    'type'      => 'text',
                    'model'     => $profile,
                    'attribute' => 'lastname',
                    'url'       => array('updateEd'), 
                    'inputclass'=> 'input-small',
                 ));
            ?>
        </p>

        <?php echo '<b>Mini-currículo: </b>';?>
        <p id="resume">            
            <?php
                $this->widget('editable.EditableField', array(
                    'type'      => 'textarea',
                    'model'     => $profile,
                    'attribute' => 'resume',
                    'url'       => array('updateEd'),  
                    'mode'      => 'inline', 
                    'emptytext' => '(Mini-resumé)',
                    'htmlOptions'=> array(
                        'id' => 'resume-edit'
                    ),
                    'options'    => array(
                        'rows'      => 5,
                        'tpl'=> '<textarea style="resize: vertical; width: 330px"></textarea>'

                    )
                 ));
            ?>
        </p>

        <script type='text/javascript'>	
            $(function() {
                $('#resume').tooltip({
                    trigger: 'manual', 
                    placement: 'right', 
                    title: '<img src=<?php echo Yii::app()->request->baseUrl.'/images/sample-mini-resume.png';?> >',
                    html: true,
                });
                $('#resume-edit').on('shown', function(e, editable) {
                    $('#resume').tooltip('show');
                    $(".tooltip").css("left","650px");
                });	
                $('#resume-edit').on('hidden', function(e, editable) {
                    $('#resume').tooltip('hide');
                });	
            });
        </script>
        
        <p> <?php echo '<b>Cidade: </b>';?>
            <?php           
            $this->widget('editable.EditableField', array(
                'type'      => 'select2',
                'model'     => $profile,
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
                    /*
                    'ajax' => array(
                        'url'=>$this->createUrl('suggestPerson'),
                        'dataType'=>'json',
                        'data' => "js: function(term,page) {
                            return {q: term};
                        }",
                        'results' => "js: function(data,page){
                            return {results: data};
                        }",
                    ),
                    'initSelection' => "js:function (element, callback) {
                        var id=$(element).val();
                        if (id!=='') {
                            $.ajax('".$this->createUrl('initPerson')."', {
                                dataType: 'json',
                                data: {
                                    id: id
                                }
                            }).done(function(data) {callback(data);});
                        }
                    }",                      
                     */
                ),                         
                'onHidden' => 'js: function(e, reason) {
                    $("#select2-drop-mask").css("display","none");
                    $("#select2-drop").css("display","none");
                 }'
            )); ?> 
        </p>

        <p> 
            <?php echo '<b>Papéis: </b>';?>
            <?php           
            $this->widget('editable.Editable', array(
                'type'      => 'select2',
                'name'      => 'role',
                'pk'        => $model->id,
                'url'       => $this->createUrl('updateRoles'), 
                'source'    => CHtml::listData(Role::model()->findAll(), 'role_id', 'name'),
                'text'      => $model->getRoleNames(),  
                'value'     => $model->getRoleIds(),
                'placement' => 'right',
                'inputclass'=> 'input-xlarge',
                'select2'   => array(
                    'placeholder'=> 'Select...',
                    'multiple'=>true,
                ),
                'onHidden' => 'js: function(e, reason) {
                    $("#select2-drop-mask").css("display","none");
                    $("#select2-drop").css("display","none");
                 }'
            )); ?>
        </p>

        <div class="facebook">
            <img src=<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png>';?>
                <?php
                $this->widget('editable.EditableField', array(
                    'type'      => 'text',
                    'model'     => $profile,
                    'attribute' => 'facebook',
                    'url'       => array('updateEd'),  //url for submit data          
                    'placement' => 'right',
                    'inputclass'=> 'editable-social',
                    'options'=>array(
                        'defaultValue'=>'https://www.facebook.com/'
                    )
                 ));?>
        </div>

        <div class="twitter">
            <img src=<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png>';?>
                <?php
                $this->widget('editable.EditableField', array(
                    'type'      => 'text',
                    'model'     => $profile,
                    'attribute' => 'linkedin',
                    'url'       => array('updateEd'),  //url for submit data          
                    'placement' => 'right',
                    'inputclass'=> 'editable-social',
                    'options'=>array(
                        'defaultValue'=>'http://www.linkedin.com/pub/'
                    )
                 ));?>
        </div>

        <div class="twitter" style="margin-bottom: 10px;">
            <img src=<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png>';?>
                <?php
                $this->widget('editable.EditableField', array(
                    'type'      => 'text',
                    'model'     => $profile,
                    'attribute' => 'twitter',
                    'url'       => array('updateEd'),  //url for submit data          
                    'placement' => 'right',
                    'inputclass'=> 'editable-social',
                    'options'=>array(
                        'defaultValue'=>'https://twitter.com/'
                    )
                 ));?>
        </div>
        
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'user-image-edit-form',
            'type'=>'inline',
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),                    
        )); 
        ?>
        <?php echo '<b>Foto: </b>';?>
        <?php echo $form->fileFieldRow($profile, 'pic', array('labelOptions' => array('label' => ''))); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>'Save',
                'size'=>'normal',
                )); 
        ?>
        <?php $this->endWidget(); ?>            
        

	</div>
	
	<div class="profile-header-right">			
        <span class="edit-btn">			
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'Voltar',
                'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'normal', // null, 'large', 'small' or 'mini'
                'url'=> array('/user/profile', 'username'=>$model->username),
                'htmlOptions'=>array('style'=>'width:50px;'),
                )); 
            ?>
        </span>
	</div>
</div>
	

<div class="profile-column-l">
	
	<div class="content-wrap">

		<div class="content-head rounded">
            <i class="icon-road profile-icon"></i> O que eu faço
            <span class="tip">Informações profissionais</span>  
            <div class="arrow-container"><div class="arrow arrow-down"></div></div>
        </div>
		
		<div class="content-info edit">
            
            <div class="content-info-unit">         
                <div class="clabel">			
                    <?php echo '<b>Experiências: </b>'; ?>
                    <span class="tip">O que você já fez de mais interessante?</span>                    
                </div>
                <div class="editable-wrap">			
                    <?php $this->widget('editable.EditableField', array(
                        'type'      => 'textarea',
                        'model'     => $profile,
                        'attribute' => 'experiences',
                        'url'       => array('updateEd'),  
                     )); ?>  				
                </div>				 
            </div>   
            
            <div class="content-info-unit">
                <div class="clabel">			
                    <?php echo '<b>Skills: </b>'; ?>  
                    <span class="tip">O que você faz de melhor?</span>
                </div>
                <div class="editable-wrap">
                    <?php           
                    $this->widget('editable.Editable', array(
                        'type'      => 'select2',
                        'name'      => 'skill',
                        'pk'        => $model->id,
                        'url'       => $this->createUrl('updateSkills'), 
                        'source'    => CHtml::listData(Skill::model()->findAll(), 'skill_id', 'name'),
                        'text'      => $model->getSkillNames(),  
                        'value'     => $model->getSkillIds(),
                        'inputclass'=> 'input-large',
                        'select2'   => array(
                            'placeholder'=> 'Select...',
                            'multiple'=>true,
                        ),
                        'onHidden' => 'js: function(e, reason) {
                            $("#select2-drop-mask").css("display","none");
                            $("#select2-drop").css("display","none");
                         }'
                    )); ?>               
                </div>
            </div>
			
		</div>
		
	</div>	
	
	
	<div class="content-wrap">

		<div class="content-head rounded">
            <i class="icon-search profile-icon"></i> O que eu procuro
            <span class="tip">O que você procura na NextBlube?</span>  
            <div class="arrow-container"><div class="arrow arrow-down"></div></div>
        </div>
        
		<div class="content-info edit">
            
            <div class="content-info-unit"> 
                <div class="clabel">			
                    <?php echo '<b>Interesses: </b>'; ?>
                    <span class="tip">O que te interessa?</span>                    
                </div>
                <div class="editable-wrap">			
                    <?php $this->widget('editable.EditableField', array(
                        'type'      => 'textarea',
                        'model'     => $profile,
                        'attribute' => 'interests',
                        'url'       => array('updateEd'),  
                     )); ?> 				
                </div>
            </div>
            
            <div class="content-info-unit"> 
                <div class="clabel">			
                    <?php echo '<b>Setores de interesse: </b>'; ?> 
                    <span class="tip">Quais desses setores te interessam?</span>                    
                </div>
                <div class="editable-wrap">			
                    <?php           
                $this->widget('editable.Editable', array(
                    'type'      => 'select2',
                    'name'      => 'sector',
                    'pk'        => $model->id,
                    'url'       => $this->createUrl('updateSectors'), 
                    'source'    => CHtml::listData(Sector::model()->findAll(), 'sector_id', 'name'),
                    'text'      => $model->getSectorNames(),  
                    'value'     => $model->getSectorIds(),
                    'inputclass'=> 'input-large',
                    'select2'   => array(
                        'placeholder'=> 'Select...',
                        'multiple'=>true,
                    ),
                    'onHidden' => 'js: function(e, reason) {
                        $("#select2-drop-mask").css("display","none");
                        $("#select2-drop").css("display","none");
                     }'
                )); ?> 				
                </div>
            </div>
        
        </div> 		
	</div>	
</div>
    
<div class="profile-column-r">

	<div class="content-wrap">

		<div class="content-head rounded">
            <i class="icon-book profile-icon"></i>Contatos
            <span class="tip">Esses dados serão ocultos ao público.</span>  
            <div class="arrow-container"><div class="arrow arrow-down"></div></div>
        </div>
		
		<div class="content-info edit wnote">
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Telefone: </b>'; ?>                   
                </div>
                <div class="editable-wrap-r">			
                    <?php 
                    $this->widget('editable.EditableField', array(
                        'type'      => 'text',
                        'model'     => $profile,
                        'attribute' => 'telephone',
                        'url'       => array('updateEd'),  
                        'placement' => 'right',
                        'title'     => 'Apenas números ou + no início',
                        'mode'      => 'popup',
                        'placement' => 'top',
                        'options'=>  array(
                            'tpl'=> '<input type="text" maxlength="30">'
                        ),         
                     )); ?> 				
                </div>
            </div>
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Skype: </b>'; ?>                    
                </div>
                <div class="editable-wrap-r">			
                    <?php $this->widget('editable.EditableField', array(
                        'type'      => 'text',
                        'model'     => $profile,
                        'attribute' => 'skype',
                        'url'       => array('updateEd'),  
                        'mode'      => 'popup',
                        'placement' => 'top',
                        'options'=>  array(
                            'tpl'=> '<input type="text" maxlength="45">'
                        ),
                     )); ?> 				
                </div>
            </div>
            
            <div class="profile-note">
                OBS: Essas informações servirão para nós entrarmos em contato se necessário.
            </div>            
		</div>
		
	</div>	

	<div class="content-wrap">

		<div class="content-head rounded">
            <i class="icon-smile profile-icon"></i>Pessoal
            <span class="tip">Esses dados serão ocultos ao público.</span>  
            <div class="arrow-container"><div class="arrow arrow-down"></div></div>
        </div>
		
		<div class="content-info edit wnote">
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Sexo: </b>'; ?>                   
                </div>
                <div class="editable-wrap-r">			
                    <?php $this->widget('editable.EditableField', array(
                        'type'      => 'select',
                        'model'     => $profile,
                        'attribute' => 'gender',
                        'url'       => array('updateEd'),  
                        'source'    => array(
                            'M' => 'Male',
                            'F' => 'Female',
                        ), 
                        'mode'      => 'popup',
                        'placement' => 'top',
                        'options'   => array(
                            'prepend'   => '',
                        )    
                     )); ?>  				
                </div>
            </div>
            
            <div class="content-info-unit"> 
                <div class="clabel-r">			
                    <?php echo '<b>Data de nascimento: </b>'; ?>                   
                </div>
                <div class="editable-wrap-r">			
                    <?php $this->widget('editable.EditableField', array(
                        'type'      => 'combodate',
                        'model'     => $profile,
                        'attribute' => 'birthday',
                        'url'       => array('updateEd'),  
                        'mode'      => 'popup',
                        'placement' => 'top',
                        'format'      => 'YYYY-MM-DD', //format in which date is expected from model and submitted to server
                        'viewformat'  => 'DD/MM/YYYY', //format in which date is displayed
                        'template'    => 'D / MMM / YYYY',
                        'options'   => array(
                            'defaultValue'   => date('Y-m-d'),
                        )
                     )); ?>  				
                </div>
            </div>
            
            <div class="profile-note">
                OBS: Essas informações são necessárias para você investir ou pedir investimento.
            </div>
		</div>
		
	</div>	
</div>


