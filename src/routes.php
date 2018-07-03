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

$app->options('/api/{routes:.+}',function($request, $response, $args){
    return $res;
});


require __DIR__ . '/routes/usuario.php';
require __DIR__ . '/routes/artista.php';
require __DIR__ . '/routes/musica.php';
require __DIR__ . '/routes/playlist.php';
require __DIR__ . '/routes/auth.php';
