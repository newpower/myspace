<?php


Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');


// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'theme'=>'bootstrap', // requires you to copy the theme under your themes directory

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'agro2b front',
	'language'=> 'ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',

	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		 'admin',
		'gii'=>array(
		   	'generatorPaths'=>array(
	     	'bootstrap.gii',
	         ),
			'class'=>'system.gii.GiiModule',
			'password'=>'1234567aA', 
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('*','127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'bootstrap'=>array(
	    'class'=>'bootstrap.components.Bootstrap',
	        ),
		'authManager' => array(
    	// Будем использовать свой менеджер авторизации
   		 'class' => 'PhpAuthManager',
   		 // Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
  		  'defaultRoles' => array('guest'),
			),
		
		'user'=>array(
  		  'class' => 'WebUser',
  			  // …
		
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		
		
		
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		
			'db'=>array(
			'connectionString' => 'mysql:localhost;dbname=nawww_main',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '280286',
			'charset' => 'utf8',
			'tablePrefix'=> 'agro2b',
		),
		*/
		
		 
		/*
		 * 		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		// uncomment the following to use a MySQL database
		
			'db'=>array(
			'connectionString' => 'mysql:host=s9n.steadyhost.ru;dbname=nawww_main',
			'emulatePrepare' => true,
			'username' => 'nawww_admin',
			'password' => '1234567aA',
			'charset' => 'utf8',
			'tablePrefix'=> 'agro2b',
		),
		 * */
		 
		
		
		'db'=>array(
			'connectionString' => 'mysql:host=93.171.202.18;dbname=user2324_main',
			'emulatePrepare' => true,
			'username' => 'user2324_nawww',
			'password' => '1234567aA',
			'charset' => 'utf8',
			'tablePrefix'=> 'agro2b',
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
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);