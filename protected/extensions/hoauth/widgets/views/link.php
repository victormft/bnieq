<?php
/**
 * @var HOAuthWidget $this
 * @var string $provider name of provider
 */

$additionalClass = $this->onlyIcons ? 'icon' : '';
$invitation = Yii::app()->user->isGuest ? UserModule::t('Sign in with') : UserModule::t('Connect with');
?>
<p>
    <a href="<?php echo Yii::app()->createUrl($this->route . '/oauth', array('provider' => $provider)); ?>" class="zocial <?= $additionalClass . ' ' . strtolower($provider) ?>"><?= "$invitation $provider"; ?></a>
</p>