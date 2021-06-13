<?php
require __DIR__ . "/../vendor/autoload.php";

use Foroupna\Controllers\HomeController;
use Foroupna\Controllers\ResurceController;

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;

// Collector Init
$route = new RouteCollector();

// header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Max-Age: 20');  
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");


/*----------  Home Routes  ----------*/
$route->get(basename(__FILE__) . '/', [HomeController::class, 'redirect']);
$route->get(basename(__FILE__) . '/home', [HomeController::class, 'showHome']);
/*----------  End of Home Routes  ----------*/

/*----------  Resurces Routes  ----------*/
$route->get(basename(__FILE__) .'/res/css/{cssname}',[ResurceController::class,"getCss"]);
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
    echo "Error: Ruta no encountered";
    var_dump($e);
} catch (HttpMethodNotAllowedException $e) {
    echo "Error: Ruta encountered pero método no permitido";
    var_dump($e);
}

/*=====  End of Dispatcher  ======*/



/*=====  End of Router File  ======*/
