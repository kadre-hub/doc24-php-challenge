<?php

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;

require __DIR__ .'/../vendor/autoload.php';
require __DIR__ .'/../config/settings.php';
require __DIR__.'/../app/Models/Turno.php'; 
require __DIR__.'/../app/Models/Institucion.php'; 
require __DIR__.'/../app/Models/Doctor.php';
require __DIR__.'/../app/Models/Usuario.php';
require __DIR__.'/../app/Traits/ValidacionDatosTrait.php';
require __DIR__.'/../app/Controllers/TurnosController.php';
require __DIR__.'/../app/Controllers/AuthController.php';
require __DIR__.'/../app/Middlewares/AuthenticationMiddleware.php';

$app = AppFactory::create();

$app->add(new Slim\Middleware\MethodOverrideMiddleware);

$app->addRoutingMiddleware();

$app->get('/obtenerTurno/{id}', \App\Controllers\TurnosController::class . ':obtenerTurno')->add(new AuthenticationMiddleware());
$app->post('/altaTurno', \App\Controllers\TurnosController::class . ':altaTurno')->add(new AuthenticationMiddleware());
$app->delete('/cancelarTurno/{id}', \App\Controllers\TurnosController::class . ':cancelarTurno')->add(new AuthenticationMiddleware());
$app->post('/actualizarTurno/{id}', \App\Controllers\TurnosController::class . ':actualizarTurno')->add(new AuthenticationMiddleware());
$app->get('/obtenerTurnos', \App\Controllers\TurnosController::class . ':obtenerTurnos')->add(new AuthenticationMiddleware());
$app->post('/login', \App\Controllers\AuthController::class . ':login');
$app->get('/logout', \App\Controllers\AuthController::class . ':logout')->add(new AuthenticationMiddleware());

$app->run();