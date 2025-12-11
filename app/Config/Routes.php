<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/log-polres', 'Home::loginPolres');
$routes->get('/log-polsek', 'Home::loginPolsek');
$routes->get('/lupa-password', 'Home::lupaPassword');
$routes->get('/reset-password', 'Home::resetPassword');
$routes->post('/lupa-password/send-email', 'Auth::sendEmailForgotPassword');
$routes->post('/lupa-password/reset-password', 'Auth::verifyAndChangePasswordForgotPassword');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/unauthorized', 'Auth::unauthorized');
$routes->get('/error-verify-account', 'Auth::errorVerifyAccount');
$routes->get('/verify-account/(:any)', 'Auth::verifyAccount/$1');



// polres
$routes->group("polres",["filter" => "authpolres"], function ($routes) {
    $routes->get('', 'Polres::index');
    $routes->get('data-anggota', 'Polres::dataAnggota');
    $routes->get('edit-nilai/(:any)', 'Polres::editNilai/$1');
    $routes->get('filter-nilai/(:any)', 'Polres::filterNilai/$1');
    $routes->get('kelola-akun', 'Polres::kelolaAkun');
    $routes->post('register', 'Auth::register');
    $routes->get('delete-account/(:any)', 'Auth::deleteAccount/$1');
    $routes->get('ganti-password', 'Polres::gantiPassword');
    $routes->post('change-password', 'Auth::changePassword');
    $routes->get('filter-laporan', 'Polres::filterLaporan');
    $routes->get('laporan', 'Polres::viewLaporan');
    $routes->post('cetak-laporan', 'Polres::exportLaporan');
});

// polsek
$routes->group("polsek", ["filter" => "authpolsek"], function ($routes) {
    $routes->get('', 'Polsek::index');
    $routes->get('data-anggota', 'Polsek::dataAnggota');
    $routes->get('filter-nilai/(:any)', 'Polsek::filterNilai/$1');
    $routes->get('ganti-password', 'Polsek::gantiPassword');
    $routes->post('change-password', 'Auth::changePassword');
    $routes->post('tambah-anggota', 'Polsek::addAnggota');
    $routes->get('edit-anggota/(:any)', 'Polsek::editViewAnggota/$1');
    $routes->post('edit-anggota/(:any)', 'Polsek::updateAnggota/$1');
    $routes->get('delete-anggota/(:any)', 'Polsek::deleteAnggota/$1');
    $routes->get('cek-nilai/(:any)', 'Polsek::cekNilai/$1');
    $routes->post('tambah-nilai/(:any)', 'Polsek::addNilai/$1');
    $routes->get('delete-nilai/(:any)', 'Polsek::deleteNilai/$1');
    $routes->get('edit-nilai/(:any)', 'Polsek::editViewNilai/$1');
    $routes->post('edit-nilai/(:any)', 'Polsek::editNilai/$1');
});