<?php

use \Phpmig\Adapter;
use \Pimple;
use \Doctrine\DBAL\DriverManager;

$container = new Pimple();

$container['db.dsn'] = getenv('DATABASE_DSN');

$container['db'] = function($c) {
    $dbh = new PDO($c['db.dsn']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return DriverManager::getConnection(array(
        'pdo' => $dbh
    ));
};

$container['phpmig.adapter'] = function ($c) {
    return new Adapter\Doctrine\DBAL($c['db'], 'migrations');
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;

