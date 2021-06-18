<?php
require __DIR__ . "/../vendor/autoload.php";

use Foroupna\Controllers\HomeController;
use Foroupna\Controllers\ResurceController;
use Foroupna\Controllers\LoginController;
use Foroupna\Controllers\RegistrarController;
use Foroupna\Controllers\BuscadorController;
use Foroupna\Controllers\BackendConxController;
use Foroupna\Controllers\CrearForoController;
use Foroupna\Controllers\ForoController;
use Foroupna\Controllers\PerfilController;
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
header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');
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
$route->post(basename(__FILE__) . '/buscador/find', [BuscadorController::class, 'buscar']);
/*----------  End of Buscador Routes  ----------*/

/*----------  Perfil Routes  ----------*/
$route->get(basename(__FILE__) . '/perfil', [PerfilController::class, 'showPerfil']);
$route->get(basename(__FILE__) . '/perfil/editar', [PerfilController::class, 'showPerfilEditiar']);
/*----------  End of Perfil Routes  ----------*/

/*----------  CrearForo Routes  ----------*/
$route->get(basename(__FILE__) . '/makeforo', [CrearForoController::class, 'showCrearForo']);
/*----------  End of CrearForo Routes  ----------*/

/*----------  Foro Routes  ----------*/
$route->get(basename(__FILE__) . '/foro/{id_foro}', [ForoController::class, 'showForo']);
$route->post(basename(__FILE__) . '/foro/loadComments', [ForoController::class, 'loadComments']);
/*----------  End of Foro Routes  ----------*/

/*----------  BackenAuth Routes  ----------*/
$route->post(basename(__FILE__) .'/back/login',[BackendConxController::class,"logIn"]);
$route->get(basename(__FILE__) .'/back/logOut',[BackendConxController::class,"logOut"]);
$route->get(basename(__FILE__) .'/back/checkUser',[BackendConxController::class,"checkUser"]);
$route->post(basename(__FILE__) . '/back/makeforo', [BackendConxController::class, "upData"]);
$route->post(basename(__FILE__) . '/back/registrar', [BackendConxController::class, "registar"]);
$route->post(basename(__FILE__) . '/back/comentar', [BackendConxController::class, "comentar"]);
$route->post(basename(__FILE__) . '/back/updateperfil', [BackendConxController::class, "updatePerfil"]);
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
