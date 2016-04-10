<?php

// This is the database connection configuration.
return array(
	//'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
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
);