<?php

// This is the database connection configuration.
return [
	// 'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	'class' => 'CDbConnection',
	'connectionString' => 'mysql:host=db;dbname=' . getenv('MYSQL_DATABASE'),
	'emulatePrepare' => false, // отключим, чтобы числа позвращались из PDO как числа, а не строки для PHP >= 8.1
	'username' => getenv('MYSQL_USER'),
	'password' => getenv('MYSQL_PASSWORD'),
	'charset' => 'utf8',	
];