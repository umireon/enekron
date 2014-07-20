<?php defined('SYSPATH') or die('No direct access allowed.');

$dbpath = getenv('DBPATH');
$dbhost = getenv('DBHOST');
$dbname = getenv('DBNAME');
$dbuser = getenv('DBUSER');
$dbpass = getenv('DBPASS');

return array(
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
		'charset'      => 'utf8',
	),
	'sqlite' => array(
		'type' => 'pdo',
		'connection' => array(
			'dsn'      => "sqlite:$dbpath",
		),
	),
);
