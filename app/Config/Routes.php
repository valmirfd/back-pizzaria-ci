<?php

use App\Controllers\Api\V1\CategoriasController;
use App\Controllers\Api\V1\ImagesProductsController;
use App\Controllers\Api\V1\ItemsController;
use App\Controllers\Api\V1\LoginController;
use App\Controllers\Api\V1\OrdensSuportController;
use App\Controllers\Api\V1\OrdersController;
use App\Controllers\Api\V1\ProdutosController;
use App\Controllers\Api\V1\ProdutoSuportController;
use App\Controllers\Api\V1\RegisterController;
use App\Controllers\Api\V1\UserController;
use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

service('auth')->routes($routes);

$routes->group('api', ['namespace' => ''], static function ($routes) {

    //Rotas para Registro
    $routes->post('register', [RegisterController::class, 'create']);
    $routes->options('register', static function () {});
    $routes->options('register/(:any)', static function () {});

    //Rotas para Login
    $routes->post('login', [LoginController::class, 'create']);
    $routes->options('login', static function () {});
    $routes->options('login/(:any)', static function () {});


    $routes->group('', ['filter' => 'jwt'], static function ($routes) {
        //Categorias
        $routes->resource('categorias', ['controller' => CategoriasController::class, 'except' => 'new,edit']);
        $routes->options('categorias', static function () {});
        $routes->options('categorias/(:any)', static function () {});

        //Produtos
        $routes->resource('produtos', ['controller' => ProdutosController::class, 'except' => 'new,edit']);
        $routes->options('produtos', static function () {});
        $routes->options('produtos/(:any)', static function () {});

        $routes->get('products-by-category/(:num)', [ProdutoSuportController::class, 'getProdutosPorCategorias']);

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

        $routes->put('order-send/(:num)', [OrdensSuportController::class, 'fecharPedido']);

        //Itens
        $routes->resource('items', ['controller' => ItemsController::class, 'except' => 'new,edit']);
        $routes->options('items', static function () {});
        $routes->options('items/(:any)', static function () {});

        //Rotas para usuários
        $routes->get('user', [UserController::class, 'index']);
        $routes->options('user', static function () {});
        $routes->options('user/(:any)', static function () {});
    });
});
