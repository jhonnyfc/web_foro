<?php
require __DIR__ . "/../vendor/autoload.php";

use Foroupna\Controllers\HomeController;
use Foroupna\Controllers\ResurceController;
use Foroupna\Controllers\LoginController;
use Foroupna\Controllers\RegistrarController;
use Foroupna\Controllers\BuscadorController;
use Foroupna\Controllers\BackendConxController;
use Foroupna\Controllers\CrearForoController;
use Foroupna\Controllers\PerfilController;

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;


// Collector Init
$route = new RouteCollector();

// header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 5');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");


/*----------  Home Routes  ----------*/
$route->get(basename(__FILE__) . '/', [HomeController::class, 'redirect']);
$route->get(basename(__FILE__) . '/home', [HomeController::class, 'showHome']);
/*----------  End of Home Routes  ----------*/

/*----------  Login Routes  ----------*/
$route->get(basename(__FILE__) . '/login', [LoginController::class, 'showLogin']);
/*----------  End of Login Routes  ----------*/

/*----------  Registrar Routes  ----------*/
$route->get(basename(__FILE__) . '/registrar', [RegistrarController::class, 'showRegistrar']);
/*----------  End of Registrar Routes  ----------*/

/*----------  Buscador Routes  ----------*/
$route->get(basename(__FILE__) . '/buscador', [BuscadorController::class, 'showBuscador']);
/*----------  End of Buscador Routes  ----------*/

/*----------  Perfil Routes  ----------*/
$route->get(basename(__FILE__) . '/perfil', [PerfilController::class, 'showPerfil']);
/*----------  End of Perfil Routes  ----------*/

/*----------  CrearForo Routes  ----------*/
$route->get(basename(__FILE__) . '/makeforo', [CrearForoController::class, 'showCrearForo']);
/*----------  End of CrearForo Routes  ----------*/

/*----------  BackenAuth Routes  ----------*/
$route->post(basename(__FILE__) .'/back/login',[BackendConxController::class,"logIn"]);
$route->get(basename(__FILE__) .'/back/logOut',[BackendConxController::class,"logOut"]);
$route->get(basename(__FILE__) .'/back/checkUser',[BackendConxController::class,"checkUser"]);
/*----------  End of BackenAuth Routes  ----------*/

/*----------  Resurces Routes  ----------*/
$route->get(basename(__FILE__) .'/res/css/{cssname}',[ResurceController::class,"getCss"]);
$route->get(basename(__FILE__) .'/res/js/{jsname}',[ResurceController::class,"getJs"]);
$route->get(basename(__FILE__) .'/res/{fotoName}',[ResurceController::class,"getDefFoto"]);
/*----------  End of Resurces Routes  ----------*/


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
