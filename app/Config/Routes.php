<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('home/beranda', 'Home::beranda');
$routes->get('home/profile', 'Home::profile');
$routes->get('home/tenagaPengajar', 'Home::tenagaPengajar');
$routes->get('home/unitKBTK', 'Home::unitKBTK');
$routes->get('home/unitTPQ', 'Home::unitTPQ');
$routes->get('home/unitDC', 'Home::unitDC');
$routes->get('home/unitLansia', 'Home::unitLansia');
$routes->get('home/informasi', 'Home::informasi');

$routes->get('index.php', 'Home::index');
$routes->get('index.php/home', 'Home::index');
$routes->get('index.php/home/beranda', 'Home::beranda');
$routes->get('index.php/home/profile', 'Home::profile');
$routes->get('index.php/home/tenagaPengajar', 'Home::tenagaPengajar');
$routes->get('index.php/home/unitKBTK', 'Home::unitKBTK');
$routes->get('index.php/home/unitTPQ', 'Home::unitTPQ');
$routes->get('index.php/home/unitDC', 'Home::unitDC');
$routes->get('index.php/home/unitLansia', 'Home::unitLansia');
$routes->get('index.php/home/informasi', 'Home::informasi');

$routes->get('admin/login', 'Admin\Otentikasi::login');
$routes->post('admin/login', 'Admin\Otentikasi::prosesLogin');
$routes->get('admin/logout', 'Admin\Otentikasi::logout');

$routes->group('admin', ['filter' => 'filteradmin'], static function ($routes) {
    $routes->get('/', 'Admin\KelolaHalaman::dashboard');
    $routes->get('dashboard', 'Admin\KelolaHalaman::dashboard');

    $routes->get('ubah-password', 'Admin\Otentikasi::ubahPassword');
    $routes->post('ubah-password', 'Admin\Otentikasi::prosesUbahPassword');

    $routes->get('halaman/(:segment)', 'Admin\KelolaHalaman::index/$1');
    $routes->get('halaman/(:segment)/tambah', 'Admin\KelolaHalaman::tambah/$1');
    $routes->post('halaman/(:segment)/simpan', 'Admin\KelolaHalaman::simpan/$1');
    $routes->get('halaman/(:segment)/edit/(:num)', 'Admin\KelolaHalaman::edit/$1/$2');
    $routes->post('halaman/(:segment)/update/(:num)', 'Admin\KelolaHalaman::update/$1/$2');
    $routes->post('halaman/(:segment)/hapus/(:num)', 'Admin\KelolaHalaman::hapus/$1/$2');
});

$routes->get('index.php/admin/login', 'Admin\Otentikasi::login');
$routes->post('index.php/admin/login', 'Admin\Otentikasi::prosesLogin');
$routes->get('index.php/admin/logout', 'Admin\Otentikasi::logout');

$routes->group('index.php/admin', ['filter' => 'filteradmin'], static function ($routes) {
    $routes->get('/', 'Admin\KelolaHalaman::dashboard');
    $routes->get('dashboard', 'Admin\KelolaHalaman::dashboard');

    $routes->get('ubah-password', 'Admin\Otentikasi::ubahPassword');
    $routes->post('ubah-password', 'Admin\Otentikasi::prosesUbahPassword');

    $routes->get('halaman/(:segment)', 'Admin\KelolaHalaman::index/$1');
    $routes->get('halaman/(:segment)/tambah', 'Admin\KelolaHalaman::tambah/$1');
    $routes->post('halaman/(:segment)/simpan', 'Admin\KelolaHalaman::simpan/$1');
    $routes->get('halaman/(:segment)/edit/(:num)', 'Admin\KelolaHalaman::edit/$1/$2');
    $routes->post('halaman/(:segment)/update/(:num)', 'Admin\KelolaHalaman::update/$1/$2');
    $routes->post('halaman/(:segment)/hapus/(:num)', 'Admin\KelolaHalaman::hapus/$1/$2');
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}