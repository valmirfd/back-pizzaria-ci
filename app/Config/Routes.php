<?php

use App\Controllers\Api\V1\CategoriasController;
use App\Controllers\Api\V1\ImagesProductsController;
use App\Controllers\Api\V1\OrdersController;
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

    $routes->group('', ['namespace' => 'App\Controllers\Api\V1'], static function ($routes) {
        $routes->group('produtos-images', ['namespace' => 'App\Controllers\Api\V1'], static function ($routes) {
            $routes->options('produtos-images', static function () {});
            $routes->post('edit/(:num)', [ImagesProductsController::class, 'editarImagensProduto']);
            $routes->options('edit/(:num)', static function () {});
            $routes->post('add/(:num)', [ImagesProductsController::class, 'addImagesProduct']);
            $routes->options('add/(:num)', static function () {});
            $routes->delete('excluir/(:num)/(:any)', [ImagesProductsController::class, 'excluirImageProduto']);
            $routes->options('excluir/(:num)/(:any)', static function () {});
        });
    });

    //Ordens
    $routes->resource('orders', ['controller' => OrdersController::class, 'except' => 'new,edit']);
    $routes->options('orders', static function () {});
    $routes->options('orders/(:any)', static function () {});

    //Itens
    $routes->resource('items', ['controller' => OrdersController::class, 'except' => 'new,edit']);
    $routes->options('items', static function () {});
    $routes->options('items/(:any)', static function () {});
});
