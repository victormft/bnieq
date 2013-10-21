<form id="langForm" action="" method="post" style="margin: 0px;">    
    <div class="language">
        <ul>
            <li>                
                <a href="#" onclick="$('#lang').val('pt'); document.getElementById('langForm').submit();">
                    <img alt="pt" width="30" height="30" src="<?php echo Yii::app()->request->baseUrl.'/images/lang/pt.png' ?>" />
                </a>
            </li>
        
            <li>
                <a href="#" onclick="$('#lang').val('en'); document.getElementById('langForm').submit();">
                    <img alt="en" width="30" height="30" src="<?php echo Yii::app()->request->baseUrl.'/images/lang/en.png' ?>" />
                </a>
            </li>
        </ul>
    </div>
    
    <input type="hidden" id="lang" name="lang" value="pt" />
</form>