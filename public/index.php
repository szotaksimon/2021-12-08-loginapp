<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager;


$db = new Manager();
$db->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'loginapp',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
]);
$db->setAsGlobal();
$db->bootEloquent();


$app = AppFactory::create();

$routes = require '../src/routes.php';
$routes($app);

$app->run();