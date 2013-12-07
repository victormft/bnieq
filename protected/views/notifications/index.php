<?php
$this->layout='column1';
?>


<div class="sub-header-bg"></div>
<h1 class="create-title" style="margin-top:25px;"><?php echo UserModule::t('Notifications'); ?></h1>
<div class="create-sub-title" style="font-style:italic; margin-bottom:60px;">Suas notificações mais recentes.</div>

<?php
$qry = new CDbCriteria( array(
    'condition' => "user_id LIKE :param",
    'order' => "time DESC",
    'params'    => array(':param' => Yii::app()->user->id),  
    'limit'=> 40
) );

$query = Notification::model()->findAll($qry); 
?>

<?php 
$html='';
foreach ($query as $q)
{
    $source = User::model()->findbypk($q->source_id);
    switch ($q->notification_type) 
    {        
        case Notification::FOLLOW_USER :
            $html .= '		
            <div style="overflow: auto; padding:0 10px 0 10px;">
                <div class="team-item">
                    <div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $source->profile->logo->name .'" /></div>
                    <div class="team-text">
                        <div class="team-resume"><b>'. $source->getFullName() . '</b> '. UserModule::t('followed you.') . '</div>
                    </div>
                </div>
            </div>
            <div class="spacing-1"></div>
            ';
            break;
        case Notification::ASK_MEMBERSHIP_STARTUP :
            $startup = Startup::model()->findbypk($q->target_id);
            $html .= '		
            <div style="overflow: auto; padding:0 10px 0 10px">
                <div class="team-item">
                    <div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $source->profile->logo->name .'" /></div>
                    <div class="team-text">
                        <div class="team-resume"><b>'. $source->getFullName() . '</b> '. UserModule::t('asked for membership in') . ' <b>' . $startup->name . '</b>.</div>
                    </div>
                </div>
            </div>
            <div class="spacing-1"></div>
            ';
            break;

        case Notification::ADDED_TO_STARTUP :
            $startup = Startup::model()->findbypk($q->target_id);
            $html .= '		
            <div style="overflow: auto; padding:0 10px 0 10px">
                <div class="team-item">
                    <div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $source->profile->logo->name .'" /></div>
                    <div class="team-text">
                        <div class="team-resume"><b>'. $source->getFullName() . '</b> '. UserModule::t('added you to') . ' <b>' . $startup->name . '</b>.</div>
                    </div>
                </div>
            </div>
            <div class="spacing-1"></div>
            ';
            break;
    }
}

echo $html;

?>
