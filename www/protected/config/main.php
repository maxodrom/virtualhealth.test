<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return [
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Web Application',

    // preloading 'log' component
    'preload' => ['log'],

    // autoloading model and component classes
    'import' => [
        'application.models.*',
        'application.components.*',
    ],

    'modules' => [
        // uncomment the following to enable the Gii tool
        /*
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'Enter Your Password Here',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
        */
    ],

    // application components
    'components' => [

        'user' => [
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ],

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
        */

        'cache' => [
            'class'=>'CFileCache',
            'cacheFileSuffix'=>'.dat',
            'directoryLevel'=>2
        ],

        // database settings are configured in database.php
        //'db'=>require(dirname(__FILE__).'/database.php'),
        'db' => [
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=virtualhealth',
            'username' => 'root',
            'password' => '',
            'tablePrefix' => 'tb_',
            'charset'=>'utf8',
            'emulatePrepare' => true,  // необходимо для некоторых версий инсталляций MySQL
            'schemaCacheID' => 'cache',
            'schemaCachingDuration' => 3600,
            'enableParamLogging' => true,
            'enableProfiling' => true,
        ],

        'errorHandler' => [
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ],

        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
                // uncomment the following to show log messages on web pages

                [
                    'class' => 'CWebLogRoute',
                ],
                [
                    'class' => 'CProfileLogRoute',
                    'report' => 'summary'
                ]

            ],
        ],

    ],

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => [
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'pageSize' => 24,
        'defaultCacheDuration' => 3600,
    ],
];
