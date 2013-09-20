<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'BNI Equity',
	'homeUrl'=>'/bnieq',
	'theme'=>'bootstrap',
	
	// preloading 'log' component
	'preload'=>array(		
		'log',
		
		//yiibooster
		'bootstrap',
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		//yii-user
        'application.modules.user.UserModule',
		'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.extensions.bootstrap.widgets.*',
        'application.extensions.editable.*', //easy include of editable classes  
        //rights
        'application.modules.rights.*', 
        'application.modules.rights.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			
			//yii-booster
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
		),
		
		//yii-user
		'user'=>array(
			'tableUsers' => 'user',
			'tableProfiles' => 'profile',
			'tableProfileFields' => 'profile_field',
			# encrypting method (php hash function)
            'hash' => 'md5', 
            # send activation email
            'sendActivationMail' => true, 
            # allow access for non-activated users
            'loginNotActiv' => false, 
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false, 
            # automatically login from registration
            'autoLogin' => true, 
            # registration path
            'registrationUrl' => array('/user/registration'), 
            # recovery password path
            'recoveryUrl' => array('/user/recovery'), 
            # login form path
            'loginUrl' => array('/user/login'), 
            # page after login
            'returnUrl' => array('/user/profile'), 
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
        
        //private-messagin module
        'message' => array(
            'userModel' => 'User',
            'getNameMethod' => 'getFullName',
            'getSuggestMethod' => 'getSuggest',
        ),
        
        //mailbox
        'mailbox'=> array(  
            'userClass' => 'User',
            'userIdColumn' => 'id',
            'usernameColumn' =>  'username',
        ),
        
        //rights
        'rights'=>array( 
            'install'=>false,            // Enables the installer. 
        ),   
				
	),

	// application components
	'components'=>array(
		'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
        ),	
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			
			//yii-user
			'class' => 'RWebUser',                      //rights: Allows super users access implicitly.
			'loginUrl' => array('/user/login'),
		),
        
        //X-editable config
        'editable' => array(
            'class'     => 'editable.EditableConfig',
            'form'      => 'bootstrap',        //form style: 'bootstrap', 'jqueryui', 'plain' 
            'mode'      => 'popup',            //mode: 'popup' or 'inline'  
            'defaults'  => array(              //default settings for all editable elements
               'emptytext' => 'Vazio'
            )
        ), 
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'caseSensitive'=>false,   
			'rules'=>array(
				'startup'=>'startup/index',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=bnieq',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		
		//yii-booster
		'bootstrap'=>array(
            'class'=>'ext.bootstrap.components.Bootstrap',
			'responsiveCss' => true,
        ),
        
        'cache'=>array(
			'class'=>'system.caching.CFileCache',
		),
        //rights
        'authManager'=>array(               // Provides support authorization item sorting
            'class'=>'RDbAuthManager',
        )
		
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);