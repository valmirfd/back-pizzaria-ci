<?php

use App\Controllers\Api\V1\CategoriasController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => ''], static function ($routes) {

    //Categorias
    $routes->resource('categorias', ['controller' => CategoriasController::class, 'except' => 'new,edit']);
    $routes->options('categorias', static function () {});
    $routes->options('categorias/(:any)', static function () {});
});
