<?php
require __DIR__ . "/../vendor/autoload.php";

use Foroupna\Controllers\UserController;
use Foroupna\Controllers\ForoController;
use Foroupna\Models\Session;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

// Collector Init
$route = new RouteCollector();

// Session Init
Session::loadSession();



// Permitimos los orignes y los valores de los headers
$allowedOrigins = [
    "http://localhost:80",
    "http://localhost:8080",
    "http://localhost"
];

if (in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

// header('Access-Control-Allow-Origin: http://localhost');
// header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");


$route->get(basename(__FILE__) . "/",function () {return "Root";});

/*----------  User Routes  ----------*/
$route->post(basename(__FILE__) . '/user/signup', [UserController::class, 'signUp']);
$route->post(basename(__FILE__) . '/user/login', [UserController::class, 'signIn']);
$route->get(basename(__FILE__) . '/user/logout', [UserController::class, 'logout']);
$route->get(basename(__FILE__) . '/user/getUser', [UserController::class, 'getUser']);
$route->get(basename(__FILE__) . '/user/find/{username}', [UserController::class, 'findUser']);
$route->post(basename(__FILE__) . '/user/updata', [UserController::class, 'upData']);
$route->post(basename(__FILE__) . '/user/upfoto', [UserController::class, 'uploadFoto']);
/*----------  End of User Routes  ----------*/

/*----------  Foro Routes  ----------*/
$route->post(basename(__FILE__) . '/foro/crear', [ForoController::class, 'createForo']);
$route->post(basename(__FILE__) . '/foro/upfoto', [ForoController::class, 'uploadFoto']);
$route->get(basename(__FILE__) . '/foro/getmostcommet/{number}', [ForoController::class, 'getMostComment']);
$route->post(basename(__FILE__) . '/foro/insertcom', [ForoController::class, 'insertComment']);
$route->post(basename(__FILE__) . '/foro/buscador', [ForoController::class, 'buscaForo']);
$route->get(basename(__FILE__) . '/foro/getlastncomment/{number}', [ForoController::class, 'getLastNcomment']);
$route->get(basename(__FILE__) . '/foro/getforobyid/{id_foro}', [ForoController::class, 'getForobyId']);
$route->post(basename(__FILE__) . '/foro/getcommentbyforo', [ForoController::class, 'getCommentsByForoId']);
/*----------  End of Foro Routes  ----------*/


/*==================================
=            Dispatcher            =
==================================*/

// Dispatcher Initialization
$dispatcher = new Dispatcher($route->getData());

try {
    echo $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
} catch (HttpRouteNotFoundException $e) {
    http_response_code(400);
    echo "Error: Ruta no encountered";
    // var_dump($e);
} catch (HttpMethodNotAllowedException $e) {
    http_response_code(400);
    echo "Error: Ruta encountered pero método no permitido";
    // var_dump($e);
}

/*=====  End of Dispatcher  ======*/



/*=====  End of Router File  ======*/
