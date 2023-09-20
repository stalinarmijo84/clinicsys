<?php

use App\Controllers\Inicio;
use App\Controllers\Login;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Login::class, 'index']);//ventana que se va abrir por defecto al iniciar.

$routes->get('/registro',[Login::class,'registro']);
$routes->post('/login/insertar',[Login::class,'insertar']);


$routes->get('/inicio',[Inicio::class,'index']);

?>
