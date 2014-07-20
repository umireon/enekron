<?php

use \Phpmig\Adapter;
use \Pimple;
use \Doctrine\DBAL\DriverManager;

$container = new Pimple();

$container['db.driver'] = function () {
	$db = getenv('DB');
	return "pdo_$db";
};

$container['db.sqlite'] = function ($c) {
	return DriverManager::getConnection(array(
		'driver'   => 'pdo_sqlite',
		'user'     => getenv('DBUSER'),
		'password' => getenv('DBPASS'),
		'path'     => getenv('DBPATH'),
	));
};

$container['db.mysql'] = function ($c) {
	return DriverManager::getConnection(array(
		'driver'   => 'pdo_mysql',
		'user'     => getenv('DBUSER'),
		'password' => getenv('DBPASS'),
		'host'     => getenv('DBHOST'),
		'port'     => getenv('DBPORT'),
		'dbname'   => getenv('DBNAME'),
		'charset'  => 'utf8',
	));
};

$container['db.pgsql'] = function ($c) {
	return DriverManager::getConnection(array(
		'driver'   => 'pdo_pgsql',
		'user'     => getenv('DBUSER'),
		'password' => getenv('DBPASS'),
		'host'     => getenv('DBHOST'),
		'port'     => getenv('DBPORT'),
		'dbname'   => getenv('DBNAME'),
		'charset'  => 'utf8',
	));
};

$container['db'] = function ($c) {
	$db = getenv('DB');
	return $c["db.$db"];
};

$container['phpmig.adapter'] = function ($c) {
    return new Adapter\Doctrine\DBAL($c['db'], 'migrations');
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;

