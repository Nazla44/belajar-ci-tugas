<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('profile', 'Home::profile', ['filter' => 'auth']);
$routes->get('faq', 'Home::faq', ['filter' => 'auth']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');
$routes->get('dashboard-toko', 'Dashboard::index');   // tambahkan


$routes->resource('api', ['controller' => 'apiController']);

$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('kategori-produk', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'KategoriProdukController::index');
    //$routes->get('tambah', 'KategoriProdukController::tambah'); // opsional
    $routes->post('simpan', 'KategoriProdukController::create');
    $routes->get('edit/(:any)', 'KategoriProdukController::edit/$1');
    $routes->post('update/(:any)', 'KategoriProdukController::update/$1');
    $routes->get('delete/(:any)', 'KategoriProdukController::delete/$1');
});
// Tambahkan alias 'role' di Config/Filters.phvp dulu
$routes->group('diskon', ['filter' => 'auth'], function ($routes) {
    $routes->get('/',               'DiskonController::index');     // GET  /diskon
    $routes->post('save',           'DiskonController::save');
    $routes->post('store',          'DiskonController::store');     // POST /diskon/store
    $routes->post('update/(:num)',  'DiskonController::update/$1'); // POST /diskon/update/7
    $routes->get('delete/(:num)',   'DiskonController::delete/$1'); // GET  /diskon/delete/7
});


$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);

$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});
