<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);


$app->add(new \Tuupola\Middleware\JwtAuthentication([
    'regexp' =>'/(.*)/',
    'header' => 'Authorization',
    'path' => '/api',
    'realm' => 'Protected', 
    'secret' => $container["settings"]['secretKey']
]));

$app->add(function($request, $response, $next){

    $response = $next($request, $response);

    return $response->withHeader('Access-Control-Allow-Origin', '*')
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Authorization, Origin, Accept')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
                    
});