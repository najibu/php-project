<?php

declare(strict_types = 1);

use App\App;
use App\Router;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controllers\HomeController;
use Illuminate\Container\Container;
use App\Controllers\InvoiceController;

require_once __DIR__ . '/../vendor/autoload.php';

define('STORAGE_PATH', __DIR__ . '/../storage');
define('VIEW_PATH', __DIR__ . '/../views');

// $container = new Container();
// $router    = new Router($container);

// $router->registerRoutesFromControllerAttributes(
//     [
//         HomeController::class,
//         InvoiceController::class,
//     ]
// );

// (new App(
//     $container,
//     $router,
//     ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
// ))->boot()->run();

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();
