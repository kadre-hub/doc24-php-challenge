<?php
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->post('/login', function (Request $request, Response $response) use ($pdo) {
  $data = $request->getParsedBody();
  $username = $data['username'] ?? '';
  $password = $data['password'] ?? '';

  // Create login validation logic here...

});

// Define your routes here...

$app->run();