<?php 

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../");
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection([
    'driver'     => $_ENV['DATABASE_DRIVER'],
    'host'       => $_ENV['DATABASE_HOST'],
    'database'   => $_ENV['DATABASE_NAME'],
    'username'   => $_ENV['DATABASE_USER'],
    'password'   => $_ENV['DATABASE_PASSWD'],
    'charset'    => $_ENV['DATABASE_CHARSET'],
    'collation'  => $_ENV['DATABASE_COLLATION'],
    'prefix'     => $_ENV['DATABASE_PREFIX']
]);

$capsule->bootEloquent();
$capsule->setAsGlobal();
?>