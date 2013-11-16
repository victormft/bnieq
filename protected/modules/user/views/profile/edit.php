<?php
$this->layout='//layouts/column1';



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
    
    <div id="startup-profile-img">
        <img src="<?php echo Yii::app()->request->baseUrl.'/images/'.$profile->logo->name ?>">    
    </div>
    
	<div class="user-profile-header-info" style="width: 600px">    
        
        <div class="content-info-unit">         
            <div class="header-label">			
                <?php echo '<b>Nome: </b>'; ?>                 
            </div>
            <div class="header-content">			
                <?php
                $this->widget('editable.EditableField', array(
                    'type'      => 'text',
                    'model'     => $profile,
                    'attribute' => 'firstname',
                    'url'       => array('updateEd'),  //url for submit data 
                    'inputclass'=> 'input-small',
                 ));
                ?>
            </div>
        </div>
        <div class="content-info-unit">
            <div class="header-label">			
                <?php echo '<b>Sobrenome: </b>'; ?>                 
            </div>
            <div class="header-content">			
                <?php            
                 $this->widget('editable.EditableField', array(
                    'type'      => 'text',
                    'model'     => $profile,
                    'attribute' => 'lastname',
                    'url'       => array('updateEd'), 
                    'inputclass'=> 'input-small',
                 ));
                ?>  				
            </div>				 
        </div>   
        
        <div class="content-info-unit">
            <div class="header-label">			
                <?php echo '<b>Mini-currículo: </b>';?>                 
            </div>
            <div class="header-content" id="resume-wrap">			
                <?php
                $this->widget('editable.EditableField', array(
                    'type'      => 'textarea',
                    'model'     => $profile,
                    'attribute' => 'resume',
                    'url'       => array('updateEd'),  
                    'mode'      => 'inline', 
                    'htmlOptions'=> array(
                        'id' => 'resume-edit'
                    ),
                    'options'    => array(
                        'rows'      => 6,
                        'tpl'=> '<textarea id="resume" onkeyup="countChar(this)" style="resize: none; width: 330px" maxlength="150"></textarea>'
                    )
                 ));
                ?>  
                <div id="count-resume" style="display: none;"></div>
            </div>
        </div>

        <script type='text/javascript'>	
            function countChar(val) {
                var id = 'count-'+val.id;
                var len = val.value.length;
                if (len > val.maxLength) {
                    val.value = val.value.substring(0, val.maxLength);
                } else {
                    $('#'+id).text(val.maxLength - len + '/' + val.maxLength);
                }
            };
                  
            $(function() {
                $('#resume-wrap').tooltip({
                    trigger: 'manual', 
                    placement: 'right', 
                    title: '<img src=<?php echo Yii::app()->request->baseUrl.'/images/sample-mini-resume.png';?> >',
                    html: true,
                });
                $('#resume-edit').on('shown', function(e, editable) {
                    $('#resume-wrap').tooltip('show');
                    $(".tooltip").css("left","770px","top","100px");
                    $(".tooltip").css("top","70px");
                    
                    $("#count-resume").css("display","block");
                });	
                $('#resume-edit').on('hidden', function(e, editable) {
                    $('#resume-wrap').tooltip('hide');
                    
                    $("#count-resume").css("display","none");
                });	
            });
        </script>
        
        <div class="content-info-unit">
            <div class="header-label">			
                <?php echo '<b>Cidade: </b>';?>                 
            </div>
            <div class="header-content">			
                <?php           
                $this->widget('editable.EditableField', array(
                    'type'      => 'select2',
                    'model'     => $profile,
                    'attribute' => 'location',
                    'url'       => $this->createUrl('updateLocation'), 
                    'source'    => Cidade::model()->getCities(),
                    'placement' => 'right',
                    'inputclass'=> 'input-large',
                    'htmlOptions'=>array('type'=>'hidden'),
                    'select2'   => array(
                        'placeholder'=> 'Select...',
                        'allowClear'=> true,   
                        'dropdownAutoWidth'=> true,
                        'minimumInputLength'=> 3,  
                    ),                         
                    'onHidden' => 'js: function(e, reason) {
                        $("#select2-drop-mask").css("display","none");
                        $("#select2-drop").css("display","none");
                     }',
                )); ?>  				
            </div>
        </div>
        
        <div class="content-info-unit">
            <div class="header-label">			
                <?php echo '<b>Papéis: </b>';?>                 
            </div>
            <div class="header-content">			
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
            </div>
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
        <div class="header-label">
            <?php echo '<b>Foto: </b>';?>
        </div>
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
	
	<div class="profile-edit-header-right">			
        <span class="edit-btn">			
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'Voltar',
                'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'normal', // null, 'large', 'small' or 'mini'
                'url'=> array('/'.$model->username),
                'htmlOptions'=>array('style'=>'width:50px;'),
                )); 
            ?>
        </span>
	</div>
</div>
	

<div class="profile-column-l">
	
    <div class="content-wrap">

		<div class="content-head rounded">
            <i class="icon-briefcase profile-icon"></i> Portfolio
            <span class="tip">Suas empresas</span>  
            <div class="arrow-container"><div class="arrow arrow-down"></div></div>
        </div>
		
		<div class="content-info edit">
            
            <?php $form = $this->beginWidget(
                'bootstrap.widgets.TbActiveForm',
                array(
                    'id' => 'inlineForm',
                    'type' => 'inline',
                    'action'=>Yii::app()->request->baseUrl.'/user/profile/addstartuprelation',
                    'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data'),
                )
            ); ?>
            
            <legend style="line-height: 20px;">Adicionar Startup &nbsp&nbsp&nbsp<div class="team-loading" style="display:inline; font-size: 15px;"></div></legend>
             
            <?php echo CHtml::activeDropDownList(new Startup,'user_role', array_merge(array(''=>'Papel...'), Startup::model()->getCompanyPositionOptions() + Startup::model()->getCompanyMembersPositionOptions()), array('name'=>'position', 'style'=>'width: 200px;'));
			?>
            
            <input type="text" id="my_ac" size="30" placeholder="Startup"/>
            <input type="hidden" id="my_ac_id" name="startup"/>
            
            
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'label'=>'Add',
                'size'=>'normal',
                'type'=>'primary',
                'htmlOptions'=>array(
                    'style'=>'display:inline; margin-left: 15px',
                    'class'=>'team-btn',
                    ),
                ));             

            $this->endWidget();
            unset($form); ?>
            
            <script>
				
            
                $(function() {
            
                var img_path = "<?php echo Yii::app()->request->baseUrl.'/images/'?>";

                $("#my_ac").autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            beforeSend: function(){
                                 $(".team-loading").html("<img src='<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif'/>");
                            },
                            url: "<?php echo Yii::app()->request->baseUrl.'/user/profile/startupsforportfolio'?>",
                            data: {term: request.term},
                            dataType: "json",
                            success: function( data ) {
                                response( $.map( data.myData, function( item ) {
                                    return {
                                        value: item.label,
                                        id: item.value,
                                        label: _highlight(item.label, request.term),
                                        label_form: item.label,
                                        image: item.image
                                    }
                                }));
                                $(".team-loading").empty();
                            },
                            error: function(){
                                $(".team-loading").html('<span style="color:red;"> Registro não encontrado! </span>').find('span').delay(1000).fadeOut(600);
                                $(".ui-autocomplete").css({'display':'none'});
                            }
                        });
                    },
                    minLength: 0,
                    delay: 300,
                    select: function( event, ui ) {
                        $( "#my_ac" ).val( ui.item.label_form);
                        $( "#my_ac_id" ).val( ui.item.id );
                        return false;
                  }
                }).data( "uiAutocomplete" )._renderItem = function( ul, item ) {
                    var inner_html = '<a><div class="list_item_container"><div class="image"><img src="' + img_path + item.image + '"></div><div class="aa">' + item.label + '</div></div></a>';
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        .append(inner_html)
                        .appendTo( ul );
                };

                function _highlight(s, t) {
                    var matcher = new RegExp("("+$.ui.autocomplete.escapeRegex(t)+")", "ig" );
                    return s.replace(matcher, "<strong>$1</strong>");
                }
            });
			</script>
            
            <?php 
            $criteria=new CDbCriteria;
            $criteria->addCondition('t.user_id = :userId');
            $criteria->params = array(
                'userId' => $model->id,
            );        
            $criteria->select="t.*,(SELECT startup.name FROM startup WHERE t.startup_id=startup.id) AS startup_name";                

            $startupProvider = new CActiveDataProvider('UserStartup', array('criteria' => $criteria,));            
            ?>
            
            <?php $this->widget('bootstrap.widgets.TbExtendedGridView', array(
                'id'=>'portfolio-grid',
                'type'=>'striped bordered',
                'enableSorting' => false,
                //'sortableRows'=>true,
                //'sortableAttribute' => 'order',
                //'sortableAjaxSave' => true,
                //'sortableAction' => 'user/profile/sortable',
                //'afterSortableUpdate' => 'js:function(id, position){ console.log("id: "+id+", position:"+position);}',
                'dataProvider' => $startupProvider,
                'template' => "{items}",
                'rowCssClassExpression'=>'$data->startup->published ? $data->approved ? "" : "approved" : "published";',
                'columns' => array(
                    array(
                        'class'=>'bootstrap.widgets.TbImageColumn',
                        'imagePathExpression'=>'Yii::app()->request->baseUrl."/images/".$data->startup->logo0->name',
                        'link'=>'$data->startup->startupname',
                        'usePlaceKitten'=>FALSE,
                        'htmlOptions'=>array('style'=>'width: 30px; height: 30px;')
                    ),
                    array(
                        'header' => 'Startup',
                        'type'=>'raw',
                        'value'=>'CHtml::link($data->startup->name, array("/startup/view", "name"=>$data->startup->startupname))',                        
                    ),
                    array(
                        'name'=>'position',
                        'value'=>'UserModule::t($data->position)',
                    ),
                    array(
                        'name' => 'title',
                        'header' => 'Título',
                        'class' => 'bootstrap.widgets.TbEditableColumn',
                        'editable' => array(
                            'type' => 'text',
                            'url' => array('updatestartuprelational'),
                            'mode'=>'popup',
                            'emptytext'=>UserModule::t('Vazio'),
                        )
                    ),
                    array(
                        'class' => 'bootstrap.widgets.TbToggle2Column',
                        'toggleAction' => 'toggle',
                        'name' => 'profile',
                        'header' => 'Perfil',
                        'htmlOptions'=>array('style'=>'text-align: center;')
                    ),
                    array(
                        'htmlOptions' => array('style'=>'text-align: center;'),
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template' => '{delete}',
                        'deleteButtonUrl'=>'Yii::app()->createUrl("/user/user/deleterelation", array("uid"=>$data->user_id, "sid"=>$data->startup_id))',
                    ),                    
                ), 
            )); ?>
            
            <div class="color-square" style="background-color: #ffe4e9; width: 20px; float: left; margin-right: 10px;"></div>
            <span>Não publicado ainda. Essas startups não aparecerão no seu perfil público.</span>
            <div class="spacing-1"></div>
            <div class="color-square" style="background-color: #ccccff; width: 20px; float: left; margin-right: 10px;"></div>
            <span>Ainda não aprovado pelos administradores da startup. Essas startups não aparecerão no seu perfil público.</span>
            			
		</div>
		
	</div>	
    
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
                        'options'    => array(
                            'rows'      => 6,
                            'tpl'=> '<textarea id="experiences" onkeyup="countChar(this)" maxlength="300"></textarea>'
                        ),
                        'onShown' => 'js: function(e, reason) {
                            $("#count-experiences").css("display","block");
                        }',
                        'onHidden' => 'js: function(e, reason) {
                            $("#count-experiences").css("display","none");
                        }'
                     )); ?>  
                    <div id="count-experiences" style="display: none;"></div>
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
                        'options'    => array(
                            'rows'      => 6,
                            'tpl'=> '<textarea id="interests" onkeyup="countChar(this)" maxlength="300"></textarea>'
                        ),
                        'onShown' => 'js: function(e, reason) {
                            $("#count-interests").css("display","block");
                        }',
                        'onHidden' => 'js: function(e, reason) {
                            $("#count-interests").css("display","none");
                        }'
                     )); ?> 
                    <div id="count-interests" style="display: none;"></div>
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
    
    <div class="content-wrap">
        <div class="content-head rounded">
			<i class="icon-link profile-icon"></i> Website & Social
			<span class="tip">Edite os links para o seu site e redes sociais</span>
			<div class="arrow-container"><div class="arrow arrow-down"></div></div>
		</div>
		
		<div class="content-info edit">
			<div class="editable-wrap">
								
				<p> <img class="social-edit-img" src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/facebook.png'?>"/>     
					<?php $this->widget('editable.EditableField', array(
						'type'      => 'text',
						'model'     => $profile,
						'attribute' => 'facebook',
						'url'       => array('updateEd'),
						'inputclass'=> 'editable-social',
                        'options'=>array(
                            'defaultValue'=>'https://www.facebook.com/'
                        )
					 )); ?>  
				</p>
				
				<p> <img class="social-edit-img" src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/twitter_alt.png'?>"/>
					<?php $this->widget('editable.EditableField', array(
						'type'      => 'text',
						'model'     => $profile,
						'attribute' => 'twitter',
						'url'       => array('updateEd'), 
						'inputclass'=> 'editable-social',
                        'options'=>array(
                            'defaultValue'=>'https://www.twitter.com/'
                        )
					 )); ?>  
				</p>
				
				<p> <img class="social-edit-img" src="<?php echo Yii::app()->request->baseUrl.'/images/social-icons/20px/linkedin.png'?>"/>   
					<?php $this->widget('editable.EditableField', array(
						'type'      => 'text',
						'model'     => $profile,
						'attribute' => 'linkedin',
						'url'       => array('updateEd'), 
						'inputclass'=> 'editable-social',
                        'options'=>array(
                            'defaultValue'=>'http://www.linkedin.com/pub/'
                        )
					 )); ?>  
				</p>
                
                <p> <i class="icon-globe web"></i>       
					<?php $this->widget('editable.EditableField', array(
						'type'      => 'text',
						'model'     => $profile,
						'attribute' => 'website',
						'url'       => array('updateEd'),
						'inputclass'=> 'editable-social',
                        'options'=>array(
                            'defaultValue'=>'http://www.'
                        )
					 )); ?>  
				</p>
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
		
		<div class="content-info edit wnote" style="overflow: visible;">
            
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
		
		<div class="content-info edit wnote" style="overflow: visible;">
            
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
                        'placement' => 'right',
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
                        'placement' => 'left',
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


