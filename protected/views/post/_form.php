<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript">
// here is the magic

function createPost()
{
    <?php echo CHtml::ajax(array(
            'url'=>array('post/create?threadId=7'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogPost div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogPost div.divForForm form').submit(createPost);
                }
                else
                {
                    $('#dialogPost div.divForForm').html(data.div);
                    setTimeout(\"$('#dialogPost').dialog('close') \",3000);
                }
 
            } ",
            ))?>;
    return false; 
 
}
 
</script>

<?php echo CHtml::link('Create', "",  // the link for open the dialog
    array(
        'style'=>'cursor: pointer; text-decoration: underline;',
        'onclick'=>"{createPost(); $('#dialogPost').dialog('open');}"));?>
 
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPost',
    'options'=>array(
        'title'=>'Create',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>470,
    ),
));?>
<div class="divForForm"></div>
 
<?php $this->endWidget(); ?>

 





























<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>


	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


	
	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row buttons">
		<?php //echo CHtml::Button('SUBMIT',array('onclick'=>'sendPostCreateForm();')); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		<?php
		/*echo CHtml::ajaxSubmitButton('Save','//pitch/index',array(
		'type'=>'POST',
		'dataType'=>'json',
		'success'=> 'js:function(data){
			if(data.result==="success"){
			$("#pitch-ajax-container").html(data.msg);
          // do something on success, like redirect
       }
	   else{
       }
   }',
));*/
?>




	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->







