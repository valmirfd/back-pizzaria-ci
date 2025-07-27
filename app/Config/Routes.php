<?php

use App\Controllers\Api\V1\CategoriasController;
use App\Controllers\Api\V1\ProdutosController;
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

    //Produtos
    $routes->resource('produtos', ['controller' => ProdutosController::class, 'except' => 'new,edit']);
    $routes->options('produtos', static function () {});
    $routes->options('produtos/(:any)', static function () {});
});
