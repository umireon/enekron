<?php

use \Phpmig\Adapter;
use \Pimple;
use \Doctrine\DBAL\DriverManager;

$container = new Pimple();

$container['db.driver'] = getenv('DB') ?: 'default';

$container['db.default'] = array(
	'driver'   => 'pdo_sqlite',
	'path'     => '../application/default.sqlite3',
);

$container['db.sqlite'] = array(
	'driver'   => 'pdo_sqlite',
	'user'     => getenv('DBUSER'),
	'password' => getenv('DBPASS'),
	'path'     => getenv('DBPATH'),
);

$container['db.mysql'] = array(
	'driver'   => 'pdo_mysql',
	'user'     => getenv('DBUSER'),
	'password' => getenv('DBPASS'),
	'host'     => getenv('DBHOST'),
	'port'     => getenv('DBPORT'),
	'dbname'   => getenv('DBNAME'),
	'charset'  => 'utf8',
);

$container['db.pgsql'] = array(
	'driver'   => 'pdo_pgsql',
	'user'     => getenv('DBUSER'),
	'password' => getenv('DBPASS'),
	'host'     => getenv('DBHOST'),
	'port'     => getenv('DBPORT'),
	'dbname'   => getenv('DBNAME'),
	'charset'  => 'utf8',
);

$container['db'] = function ($c) {
	$driver = $c['db.driver'];
	$config = $c["db.$driver"];
	return DriverManager::getConnection($config);
};

$container['phpmig.adapter'] = function ($c) {
    return new Adapter\Doctrine\DBAL($c['db'], 'migrations');
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;

