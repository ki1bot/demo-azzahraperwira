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

$routes->get('admin/login/index.php', 'Admin\Otentikasi::login');
$routes->post('admin/login/index.php', 'Admin\Otentikasi::prosesLogin');
$routes->get('admin/logout/index.php', 'Admin\Otentikasi::logout');

$routes->group('admin', ['filter' => 'filteradmin'], static function (RouteCollection $routes) {
    $routes->get('dashboard/index.php', 'Admin\KelolaHalaman::dashboard');

    $routes->get('ubah-password/index.php', 'Admin\Otentikasi::ubahPassword');
    $routes->post('ubah-password/index.php', 'Admin\Otentikasi::prosesUbahPassword');

    $routes->get('halaman/beranda/index.php', 'Admin\KelolaHalaman::index/beranda');
    $routes->get('halaman/beranda/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/beranda/$1');
    $routes->post('halaman/beranda/update/(:num)/index.php', 'Admin\KelolaHalaman::update/beranda/$1');

    $routes->get('halaman/profile/index.php', 'Admin\KelolaHalaman::index/profile');
    $routes->get('halaman/profile/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/profile/$1');
    $routes->post('halaman/profile/update/(:num)/index.php', 'Admin\KelolaHalaman::update/profile/$1');

    $routes->get('halaman/tenaga-pengajar/index.php', 'Admin\KelolaHalaman::index/tenaga-pengajar');
    $routes->get('halaman/tenaga-pengajar/tambah/index.php', 'Admin\KelolaHalaman::tambah/tenaga-pengajar');
    $routes->post('halaman/tenaga-pengajar/simpan/index.php', 'Admin\KelolaHalaman::simpan/tenaga-pengajar');
    $routes->get('halaman/tenaga-pengajar/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/tenaga-pengajar/$1');
    $routes->post('halaman/tenaga-pengajar/update/(:num)/index.php', 'Admin\KelolaHalaman::update/tenaga-pengajar/$1');
    $routes->post('halaman/tenaga-pengajar/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/tenaga-pengajar/$1');

    $routes->get('halaman/unit-kb-tk/index.php', 'Admin\KelolaHalaman::index/unit-kb-tk');
    $routes->get('halaman/unit-kb-tk/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/unit-kb-tk/$1');
    $routes->post('halaman/unit-kb-tk/update/(:num)/index.php', 'Admin\KelolaHalaman::update/unit-kb-tk/$1');

    $routes->get('halaman/unit-tpq/index.php', 'Admin\KelolaHalaman::index/unit-tpq');
    $routes->get('halaman/unit-tpq/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/unit-tpq/$1');
    $routes->post('halaman/unit-tpq/update/(:num)/index.php', 'Admin\KelolaHalaman::update/unit-tpq/$1');

    $routes->get('halaman/unit-dc/index.php', 'Admin\KelolaHalaman::index/unit-dc');
    $routes->get('halaman/unit-dc/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/unit-dc/$1');
    $routes->post('halaman/unit-dc/update/(:num)/index.php', 'Admin\KelolaHalaman::update/unit-dc/$1');

    $routes->get('halaman/unit-lansia/index.php', 'Admin\KelolaHalaman::index/unit-lansia');
    $routes->get('halaman/unit-lansia/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/unit-lansia/$1');
    $routes->post('halaman/unit-lansia/update/(:num)/index.php', 'Admin\KelolaHalaman::update/unit-lansia/$1');

    $routes->get('halaman/informasi/index.php', 'Admin\KelolaHalaman::index/informasi');
    $routes->get('halaman/informasi/tambah/index.php', 'Admin\KelolaHalaman::tambah/informasi');
    $routes->post('halaman/informasi/simpan/index.php', 'Admin\KelolaHalaman::simpan/informasi');
    $routes->get('halaman/informasi/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/informasi/$1');
    $routes->post('halaman/informasi/update/(:num)/index.php', 'Admin\KelolaHalaman::update/informasi/$1');
    $routes->post('halaman/informasi/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/informasi/$1');

    $routes->get('halaman/footer/index.php', 'Admin\KelolaHalaman::index/footer');
    $routes->get('halaman/footer/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/footer/$1');
    $routes->post('halaman/footer/update/(:num)/index.php', 'Admin\KelolaHalaman::update/footer/$1');
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}