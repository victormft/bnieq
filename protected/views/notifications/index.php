<?php
$this->layout='column1';
?>


<div class="sub-header-bg"></div>
<h1 class="create-title" style="margin-top:25px;"><?php echo UserModule::t('Notifications'); ?></h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:60px;"><?php echo UserModule::t('Your most recent notifications.'); ?></div>

<?php
echo $html;
