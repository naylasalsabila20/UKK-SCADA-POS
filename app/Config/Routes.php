<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::login');
$routes->post('/login','Home::login');
$routes->get('/halaman-admin','Home::halamanAdmin',['filter'=>'autentifikasi']);
$routes->get('/logout', 'Home::logout');


//master data

//satuan
$routes->get('/master-data-satuan','Satuan::index',['filter'=>'autentifikasi']);
$routes->get('/hapus-satuan/(:num)', 'Satuan::hapus/$1',['filter'=>'autentifikasi']);
$routes->get('/master-data-satuan', 'Satuan::tambah',['filter'=>'autentifikasi']);
$routes->post('/master-data-satuan', 'Satuan::tambah',['filter'=>'autentifikasi']);
$routes->post('/edit-satuan', 'Satuan::update',['filter'=>'autentifikasi']);


//kategori
$routes->get('/master-data-kategori','Kategori::index',['filter'=>'autentifikasi']);
$routes->get('/hapus-kategori/(:num)', 'Kategori::hapus/$1',['filter'=>'autentifikasi']);
$routes->get('/master-data-kategori', 'Kategori::tambah',['filter'=>'autentifikasi']);
$routes->post('/master-data-kategori', 'Kategori::tambah',['filter'=>'autentifikasi']);
$routes->post('/edit-kategori', 'Kategori::update',['filter'=>'autentifikasi']);

//produk
$routes->get('/master-data-produk','Produk::index',['filter'=>'autentifikasi']);
$routes->get('/hapus-produk/(:any)', 'Produk::hapus/$1',['filter'=>'autentifikasi']);
$routes->get('/master-data-produk', 'Produk::tambah',['filter'=>'autentifikasi']);
$routes->post('/master-data-produk', 'Produk::tambah',['filter'=>'autentifikasi']);
$routes->post('/edit-produk', 'Produk::update',['filter'=>'autentifikasi']);
$routes->post('/update-stok', 'Produk::updateStok',['filter'=>'autentifikasi']);
//pengguna
$routes->get('/master-data-pengguna','Pengguna::index',['filter'=>'autentifikasi']);
$routes->get('/hapus-pengguna/(:any)', 'Pengguna::hapus/$1',['filter'=>'autentifikasi']);
$routes->get('/master-data-pengguna', 'Pengguna::tambah',['filter'=>'autentifikasi']);
$routes->post('/master-data-pengguna', 'Pengguna::tambah',['filter'=>'autentifikasi']);
$routes->post('/edit-pengguna', 'Pengguna::update',['filter'=>'autentifikasi']);
$routes->post('/edit-password', 'Pengguna::updatepassPengguna',['filter'=>'autentifikasi']);

//member
$routes->get('/master-data-member','Member::index',['filter'=>'autentifikasi']);
$routes->get('/hapus-member/(:any)', 'Member::hapus/$1',['filter'=>'autentifikasi']);
$routes->get('/master-data-member', 'Member::tambah',['filter'=>'autentifikasi']);
$routes->post('/master-data-member', 'Member::tambah',['filter'=>'autentifikasi']);
$routes->post('/edit-member', 'Member::update',['filter'=>'autentifikasi']);

//transaksi
$routes->get('/transaksi-penjualan','Penjualan::index',['filter'=>'autentifikasi']);
$routes->post('/transaksi-penjualan','Penjualan::simpanPenjualan',['filter'=>'autentifikasi']);
$routes->get('/pembayaran','Penjualan::simpanPembayaran',['filter'=>'autentifikasi']);

//laporan
$routes->get('/catak-laporan-stok','Produk::laporanStok',['filter'=>'autentifikasi']);
$routes->get('/laporan-stok','Produk::listStok',['filter'=>'autentifikasi']);
$routes->get('/laporan-penjualan','Penjualan::listPenjualan',['filter'=>'autentifikasi']);
