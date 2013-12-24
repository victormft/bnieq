<?php if ($postData != NULL)$postOwner = User::model()->findByPk($postData->user_id); ?>


<div class="thread-post-list">
	<div class="thread-title"> <?php echo $model->title; ?> </div>
	<div class="post-content"><?php echo $postData->body; ?></div>
	<div class="user-post-info">Por: <span style="color: #5FB2F5;"><?php  if($postOwner != NULL) echo $postOwner->username; ?></div>
</div>