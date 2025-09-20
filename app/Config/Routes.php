<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Publik (Bisa diakses tanpa login)
// =====================================
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::saveRegister');
$routes->get('/logout', 'AuthController::logout');


// Rute Terproteksi (HARUS LOGIN untuk mengakses)
// =============================================
$routes->group('', ['filter' => 'auth'], function($routes) {

    // Rute Dashboard (sebagai halaman utama)
    $routes->match(['get', 'post'], '/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');
    
    // Rute Kategori (Lengkap)
    $routes->get('kategori', 'Kategori::index');
    $routes->post('kategori/store', 'Kategori::store');
    $routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
    $routes->post('kategori/update', 'Kategori::update');
    $routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');

    // Rute Transaksi (Lengkap)
    $routes->get('transaksi', 'Transaksi::index');
    $routes->post('transaksi/store', 'Transaksi::store');
    $routes->get('transaksi/edit/(:num)', 'Transaksi::edit/$1');
    $routes->post('transaksi/update', 'Transaksi::update');
    $routes->get('transaksi/delete/(:num)', 'Transaksi::delete/$1');

    // Rute Laporan
    $routes->match(['get', 'post'], 'laporan', 'Laporan::index');

    $routes->get('transaksi-berulang', 'TransaksiBerulang::index');
    $routes->post('transaksi-berulang/store', 'TransaksiBerulang::store');
    $routes->get('transaksi-berulang/delete/(:num)', 'TransaksiBerulang::delete/$1');

    $routes->get('transaksi-berulang/execute', 'TransaksiBerulang::execute');
    
});