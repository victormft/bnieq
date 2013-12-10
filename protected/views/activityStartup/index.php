<?php
$this->layout='column1';
?>

<?php
$qry = new CDbCriteria( array(
    'condition' => "startup_id LIKE :param",
    'order' => "time DESC",
    'params'    => array(':param' => $model->id),  
    'limit'=> 20
) );

$query = ActivityStartup::model()->findAll($qry); 
?>

<?php 
$html='';
foreach ($query as $q)
{
    $user = User::model()->findbypk($q->user_id);
    switch ($q->activity_type) 
    {        
        case ActivityStartup::FOLLOW_STARTUP :
            $html .= '		
            <div style="overflow: auto; padding:0 10px 0 10px; line-height: 40px;">
                <div class="team-item">
                    <div class="notif-image"><img src="'. Yii::app()->request->baseUrl .'/images/'. $user->profile->logo->name .'" /></div>
                    <div class="team-text">
                        <div class="team-resume"><b>'. CHtml::link($user->getFullName(), array('/'.$user->username)) . '</b> '. UserModule::t('followed you.') . '</div>
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

