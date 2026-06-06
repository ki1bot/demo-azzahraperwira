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
    $routes->post('ubah-password/proses/index.php', 'Admin\Otentikasi::prosesUbahPassword');

    $routes->get('beranda/index.php', 'Admin\KelolaHalaman::index/beranda');
    $routes->get('beranda/tambah/index.php', 'Admin\KelolaHalaman::tambah/beranda');
    $routes->post('beranda/simpan/index.php', 'Admin\KelolaHalaman::simpan/beranda');
    $routes->get('beranda/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/beranda/$1');
    $routes->post('beranda/update/(:num)/index.php', 'Admin\KelolaHalaman::update/beranda/$1');
    $routes->post('beranda/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/beranda/$1');

    $routes->get('profile/index.php', 'Admin\KelolaHalaman::index/profile');
    $routes->get('profile/tambah/index.php', 'Admin\KelolaHalaman::tambah/profile');
    $routes->post('profile/simpan/index.php', 'Admin\KelolaHalaman::simpan/profile');
    $routes->get('profile/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/profile/$1');
    $routes->post('profile/update/(:num)/index.php', 'Admin\KelolaHalaman::update/profile/$1');
    $routes->post('profile/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/profile/$1');

    $routes->get('tenaga-pengajar/index.php', 'Admin\KelolaHalaman::index/tenaga-pengajar');
    $routes->get('tenaga-pengajar/tambah/index.php', 'Admin\KelolaHalaman::tambah/tenaga-pengajar');
    $routes->post('tenaga-pengajar/simpan/index.php', 'Admin\KelolaHalaman::simpan/tenaga-pengajar');
    $routes->get('tenaga-pengajar/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/tenaga-pengajar/$1');
    $routes->post('tenaga-pengajar/update/(:num)/index.php', 'Admin\KelolaHalaman::update/tenaga-pengajar/$1');
    $routes->post('tenaga-pengajar/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/tenaga-pengajar/$1');

    $routes->get('unit-kb-tk/index.php', 'Admin\KelolaHalaman::index/unit-kb-tk');
    $routes->get('unit-kb-tk/tambah/index.php', 'Admin\KelolaHalaman::tambah/unit-kb-tk');
    $routes->post('unit-kb-tk/simpan/index.php', 'Admin\KelolaHalaman::simpan/unit-kb-tk');
    $routes->get('unit-kb-tk/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/unit-kb-tk/$1');
    $routes->post('unit-kb-tk/update/(:num)/index.php', 'Admin\KelolaHalaman::update/unit-kb-tk/$1');
    $routes->post('unit-kb-tk/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/unit-kb-tk/$1');

    $routes->get('unit-tpq/index.php', 'Admin\KelolaHalaman::index/unit-tpq');
    $routes->get('unit-tpq/tambah/index.php', 'Admin\KelolaHalaman::tambah/unit-tpq');
    $routes->post('unit-tpq/simpan/index.php', 'Admin\KelolaHalaman::simpan/unit-tpq');
    $routes->get('unit-tpq/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/unit-tpq/$1');
    $routes->post('unit-tpq/update/(:num)/index.php', 'Admin\KelolaHalaman::update/unit-tpq/$1');
    $routes->post('unit-tpq/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/unit-tpq/$1');

    $routes->get('unit-dc/index.php', 'Admin\KelolaHalaman::index/unit-dc');
    $routes->get('unit-dc/tambah/index.php', 'Admin\KelolaHalaman::tambah/unit-dc');
    $routes->post('unit-dc/simpan/index.php', 'Admin\KelolaHalaman::simpan/unit-dc');
    $routes->get('unit-dc/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/unit-dc/$1');
    $routes->post('unit-dc/update/(:num)/index.php', 'Admin\KelolaHalaman::update/unit-dc/$1');
    $routes->post('unit-dc/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/unit-dc/$1');

    $routes->get('unit-lansia/index.php', 'Admin\KelolaHalaman::index/unit-lansia');
    $routes->get('unit-lansia/tambah/index.php', 'Admin\KelolaHalaman::tambah/unit-lansia');
    $routes->post('unit-lansia/simpan/index.php', 'Admin\KelolaHalaman::simpan/unit-lansia');
    $routes->get('unit-lansia/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/unit-lansia/$1');
    $routes->post('unit-lansia/update/(:num)/index.php', 'Admin\KelolaHalaman::update/unit-lansia/$1');
    $routes->post('unit-lansia/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/unit-lansia/$1');

    $routes->get('informasi/index.php', 'Admin\KelolaHalaman::index/informasi');
    $routes->get('informasi/tambah/index.php', 'Admin\KelolaHalaman::tambah/informasi');
    $routes->post('informasi/simpan/index.php', 'Admin\KelolaHalaman::simpan/informasi');
    $routes->get('informasi/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/informasi/$1');
    $routes->post('informasi/update/(:num)/index.php', 'Admin\KelolaHalaman::update/informasi/$1');
    $routes->post('informasi/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/informasi/$1');

    $routes->get('footer/index.php', 'Admin\KelolaHalaman::index/footer');
    $routes->get('footer/tambah/index.php', 'Admin\KelolaHalaman::tambah/footer');
    $routes->post('footer/simpan/index.php', 'Admin\KelolaHalaman::simpan/footer');
    $routes->get('footer/edit/(:num)/index.php', 'Admin\KelolaHalaman::edit/footer/$1');
    $routes->post('footer/update/(:num)/index.php', 'Admin\KelolaHalaman::update/footer/$1');
    $routes->post('footer/hapus/(:num)/index.php', 'Admin\KelolaHalaman::hapus/footer/$1');

    $routes->get('/', 'Admin\KelolaHalaman::dashboard');
    $routes->get('dashboard', 'Admin\KelolaHalaman::dashboard');

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

$routes->group('index.php/admin', ['filter' => 'filteradmin'], static function (RouteCollection $routes) {
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