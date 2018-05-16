<?php

use Slim\Http\Request;
use Slim\Http\Response;

$container['db'];

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index teste view
    return $this->renderer->render($response, 'index.phtml', $args);
});


require __DIR__ . '/routes/usuario.php';