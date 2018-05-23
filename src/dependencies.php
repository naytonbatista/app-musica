<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['db'] = function($c){
    $manager = new \Illuminate\Database\Capsule\Manager;
    $manager->addConnection($c->get('settings')['db']);
    $manager->setAsGlobal('');
    $manager->bootEloquent();
    return $manager->getConnection('default');
};

$container['user_repository'] = function($c){
    $repository = new App\Repositories\UsuarioRepository($c['db']);
    return $repository;
};

$container['artista_repository'] = function($c){
    $repository = new App\Repositories\ArtistaRepository($c['db']);
    return $repository;
};

$container['musica_repository'] = function($c){
    $repository = new App\Repositories\MusicaRepository($c['db']);
    return $repository;
};
