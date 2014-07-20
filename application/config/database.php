<?php

$dbpath = getenv('DBPATH');
$dbhost = getenv('DBHOST');
$dbname = getenv('DBNAME');
$dbuser = getenv('DBUSER');
$dbpass = getenv('DBPASS');

return array(
	'default' => array(
		'type' => 'pdo',
		'connection' => array(
			'dsn'      => 'sqlite:'.APPPATH.'default.sqlite3',
		),
		'charset'      => NULL,
	),
	'mysql' => array(
		'type' => 'pdo',
		'connection' => array(
			'dsn'      => "mysql:host=$dbhost;dbname=$dbname",
			'username' => $dbuser,
			'password' => $dbpass,
		),
		'charset'      => 'utf8',
	),
	'pgsql' => array(
		'type' => 'postgresql',
		'connection' => array(
			'hostname' => $dbhost,
			'username' => $dbuser,
			'password' => $dbpass,
			'database' => $dbname,
		),
		'primary_key'  => 'id',
		'charset'      => 'utf8',
	),
	'sqlite' => array(
		'type' => 'pdo',
		'connection' => array(
			'dsn'      => "sqlite:$dbpath",
		),
	),
);
