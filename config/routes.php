<?php

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require __DIR__ .'/../vendor/autoload.php';
require __DIR__ .'/../config/settings.php';
require __DIR__.'/../app/Models/Turno.php'; 
require __DIR__.'/../app/Models/Institucion.php'; 
require __DIR__.'/../app/Models/Doctor.php';
require __DIR__.'/../app/Controllers/TurnosController.php';

$app = AppFactory::create();

$app->add(new Slim\Middleware\MethodOverrideMiddleware);


$app->addRoutingMiddleware();

$app->get('/obtenerTurno/{id}', \App\Controllers\TurnosController::class . ':obtenerTurno');
$app->post('/altaTurno', \App\Controllers\TurnosController::class . ':altaTurno');
$app->delete('/cancelarTurno/{id}', \App\Controllers\TurnosController::class . ':cancelarTurno');
$app->post('/actualizarTurno/{id}', \App\Controllers\TurnosController::class . ':actualizarTurno');
$app->get('/obtenerTurnos', \App\Controllers\TurnosController::class . ':obtenerTurnos');

$app->run();