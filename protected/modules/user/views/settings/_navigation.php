<div class="spacing-1"></div>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'id'=>'settings-menu',
    'stacked'=>true, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'General', 'url'=>'general', 'active'=>($active==='general') ? true:false),
        array('label'=>'Password', 'url'=>'password', 'active'=>($active==='pass') ? true:false),        
        array('label'=>'Investor Status', 'url'=>'investorStatus', 'active'=>($active=='investor_status') ? true:false),
        array('label'=>'Social Networks', 'url'=>'social', 'active'=>($active=='social') ? true:false),
        array('label'=>'Delete Account', 'url'=>'deleteAccount', 'active'=>($active=='delete') ? true:false),
    ),
)); 