<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<script type="text/javascript">
 
function sendPostCreateForm()
 {
 
   var data=$("post-create-wrap").serialize();
 
 
  $.ajax({
   type: 'POST',
    url: '<?php echo Yii::app()->createAbsoluteUrl("post/ajax"); ?>',
   data:data,
	success:function(data){
                alert(data); 
              },
   error: function(data) { // if error occured
         alert("Error occured.please try again");
         alert(data);
    },
 
  dataType:'html'
  });
 
}
 
</script>


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


