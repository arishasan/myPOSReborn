<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application- These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AuthController@showFormLogin');
Route::get('login', 'AuthController@showFormLogin')->name('login');
Route::post('login', 'AuthController@login')->name('login');

Route::group(['middleware' => 'auth'], function(){
	Route::get('logout', 'AuthController@logout')->name('logout');

	// ADMIN

		// supplier

		Route::get('master/supplier', 'SupplierController@index')->name('master-supplier');
		Route::get('master/supplier/get_data', 'SupplierController@get_data')->name('get-data-supplier');
		Route::post('master/supplier/simpan', 'SupplierController@store')->name('simpan-supplier');
		Route::post('master/supplier/update', 'SupplierController@update')->name('update-supplier');
		Route::get('master/supplier/edit/{id}', 'SupplierController@edit_index');
		Route::get('master/supplier/get_json/{id}', 'SupplierController@get_data_json');
		Route::get('master/supplier/delete/{id}', 'SupplierController@delete');

		// END supplier

		// supplier

		Route::get('master/satuan', 'SatuanController@index')->name('master-satuan');
		Route::get('master/satuan/get_data', 'SatuanController@get_data')->name('get-data-satuan');
		Route::post('master/satuan/simpan', 'SatuanController@store')->name('simpan-satuan');
		Route::post('master/satuan/update', 'SatuanController@update')->name('update-satuan');
		Route::get('master/satuan/edit/{id}', 'SatuanController@edit_index');
		Route::get('master/satuan/get_json/{id}', 'SatuanController@get_data_json');
		Route::get('master/satuan/delete/{id}', 'SatuanController@delete');

		// END supplier

		// KATEGORI

		Route::get('master/kategori', 'KategoriController@index')->name('master-kategori');
		Route::get('master/kategori/get_tree_kategori', 'KategoriController@get_tree')->name('get-tree-kategori');
		Route::get('master/kategori/get_data_kategori', 'KategoriController@get_kategori')->name('get-data-kategori');
		Route::post('master/kategori/simpan', 'KategoriController@store')->name('post-data-kategori');

		// END KATEGORI

		// ADM BARANG

		Route::get('master/barang', 'AdmBarangController@index')->name('adm-barang');
		Route::post('master/barang/get_data', 'AdmBarangController@get_data')->name('get-data-barang');
		Route::get('master/barang/get_detail_barang/{id}', 'AdmBarangController@get_detail_barang');
		Route::get('master/barang/edit/{id}', 'AdmBarangController@edit_index');
		Route::post('master/barang/simpan', 'AdmBarangController@store')->name('simpan-adm-barang');
		Route::post('master/barang/update', 'AdmBarangController@update')->name('update-adm-barang');
		Route::get('master/barang/delete/{id}', 'AdmBarangController@delete');
		Route::post('master/barang/get_select_barang', 'AdmBarangController@getSelect')->name('get-select-barang');

		Route::post('master/barang/get_select_po_barang', 'AdmBarangController@getSelectPOBarang')->name('get-select-po-barang');
		Route::get('master/barang/get_data_det_po/{id}', 'AdmBarangController@getDataDetPO');
		Route::get('master/barang/print/{id}', 'AdmBarangController@print_index');

		Route::get('master/barang/harga/delete/{id1}/{id2}', 'AdmBarangController@deleteHarga');
		Route::post('master/barang/harga', 'AdmBarangController@simpanHarga')->name('simpan-harga-baru');

		Route::get('master/barang/stok/delete/{id1}/{id2}', 'AdmBarangController@deleteStok');
		Route::post('master/barang/stok', 'AdmBarangController@simpanStok')->name('simpan-stok-baru');
		Route::post('master/barang/keluar', 'AdmBarangController@simpanKeluarBarang')->name('simpan-keluar-barang');

		// END ADM BARANG

		// TRANSAKSI

		Route::get('transaksi', 'TransaksiController@index')->name('transaksi');
		Route::post('transaksi/get_data', 'TransaksiController@get_main_data')->name('get-data-trx');
		Route::get('transaksi/get_detail/{id}', 'TransaksiController@get_detail');
		Route::get('transaksi/cetak_struk/{id}', 'TransaksiController@cetak_struk');
		Route::get('transaksi/void_cancel_trx/{id1}/{id2}', 'TransaksiController@do_void_cancel');
		Route::get('transaksi/delete/{id}', 'TransaksiController@delete_trx');
		Route::get('transaksi/edit/{id}', 'TransaksiController@edit_trx');
		Route::get('transaksi/detail_data/{id}', 'TransaksiController@get_detail_trx');

		Route::post('transaksi/detail_add/{id}', 'TransaksiController@add_detail')->name('simpan-detail-trx');
		Route::get('transaksi/kosongkan/{id}', 'TransaksiController@kosongkan_detail_transaksi')->name('kosongkan-detail');
		Route::get('transaksi/delete_det_item/{id}', 'TransaksiController@delete_det_item');

		Route::post('transaksi/barang/get_data', 'TransaksiController@barang_get_data')->name('get-data-barang-trx');
		Route::get('transaksi/barang/get_detail_barang_lengkap/{id}', 'TransaksiController@get_detail_barang');
		Route::post('transaksi/barang/keranjang_add', 'TransaksiController@add_keranjang')->name('simpan-keranjang');
		Route::get('transaksi/barang/keranjang_data', 'TransaksiController@get_keranjang')->name('get-data-keranjang');
		Route::get('transaksi/barang/keranjang/delete/{id}', 'TransaksiController@delete_keranjang');
		Route::get('transaksi/barang/keranjang/kosongkan', 'TransaksiController@kosongkan_keranjang')->name('kosongkan-cart');

		Route::post('transaksi/barang/simpan', 'TransaksiController@store_trx')->name('simpan-transaksi');
		Route::post('transaksi/barang/proses', 'TransaksiController@update_trx')->name('proses-update-transaksi');

		Route::get('transaksi/update_subtotal/{id1}/{id2}', 'TransaksiController@update_subtotal_trx');

		// END TRANSAKSI



		// ADM PO

		Route::get('transaksi/po', 'TrxPoController@index')->name('transaksi-po');
		Route::post('transaksi/po/simpan', 'TrxPoController@store')->name('simpan-po');
		Route::post('transaksi/po/get_data', 'TrxPoController@get_data')->name('get-data-po');
		Route::get('transaksi/po/detail/{id}', 'TrxPoController@detail_index');
		Route::get('transaksi/po/edit/{id}', 'TrxPoController@edit_index');
		Route::get('transaksi/po/det_delete/{id}', 'TrxPoController@detail_delete');
		Route::post('transaksi/po/update', 'TrxPoController@update')->name('update-po');
		Route::get('transaksi/po/delete/{id}', 'TrxPoController@delete');
		// Route::get('transaksi/po/status_selesai/{id}', 'TrxPoController@po_selesai');
		Route::post('transaksi/po/status_selesai', 'TrxPoController@po_selesai')->name('do-po-selesai');
		Route::get('transaksi/po/cetak_surat/{id}', 'TrxPoController@cetak_surat');
		Route::post('transaksi/po/tambah_item', 'TrxPoController@add_item')->name('po-tambah-item');
		Route::get('transaksi/po/lanjut/{id}/{id2}', 'TrxPoController@lanjut_po');

		Route::post('transaksi/po/proses_lanjut', 'TrxPoController@proses_lanjut')->name('proses-po');

		// END ADM PO

		// ADM REQUEST

		Route::get('administrasi/request_barang', 'AdmRequestBarangController@index')->name('adm-request-barang');
		Route::get('administrasi/request_barang/detail/{id}', 'AdmRequestBarangController@detail');
		Route::get('administrasi/request_barang/buat_disposisi/{id}', 'AdmRequestBarangController@buat_disposisi');
		Route::get('administrasi/request_barang/edit_disposisi/{id}', 'AdmRequestBarangController@edit_disposisi');
		Route::post('administrasi/request_barang/simpan', 'AdmRequestBarangController@store')->name('simpan-request-barang');
		Route::post('administrasi/request_barang/get_data', 'AdmRequestBarangController@get_data')->name('get-data-request-barang');
		Route::get('administrasi/request_barang/edit/{id}', 'AdmRequestBarangController@edit');
		Route::post('administrasi/request_barang/update', 'AdmRequestBarangController@update')->name('update-request-barang');
		Route::get('administrasi/request_barang/detail_disposisi/{id}', 'AdmRequestBarangController@detail_disposisi');
		Route::post('administrasi/request_barang/simpan_disposisi', 'AdmRequestBarangController@simpan_disposisi')->name('simpan-buat-disposisi');
		Route::post('administrasi/request_barang/simpan_update_disposisi', 'AdmRequestBarangController@simpan_update_disposisi')->name('simpan-edit-disposisi');
		Route::post('administrasi/request_barang/simpan_balasan_disposisi', 'AdmRequestBarangController@simpan_balasan_disposisi')->name('simpan-balasan-disposisi');
		Route::get('administrasi/request_barang/delete/{id}', 'AdmRequestBarangController@delete');
		Route::get('administrasi/request_barang/disposisi/delete/{id}', 'AdmRequestBarangController@disposisi_delete');

		Route::get('administrasi/request_barang/disposisi/approval/{id}/{md5}/{kondisi}', 'AdmRequestBarangController@disposisi_approval');

		Route::post('administrasi/request_barang/simpan_balasan_disposisi_forum', 'AdmRequestBarangController@simpan_balasan_disposisi_forum')->name('simpan-balasan-disposisi-forum');

		// END ADM REQUEST

		// ADM MUTASI

		Route::get('administrasi/mutasi_barang', 'AdmMutasiBarangController@index')->name('adm-mutasi-barang');
		Route::post('administrasi/mutasi_barang/simpan', 'AdmMutasiBarangController@store')->name('simpan-mutasi');
		Route::post('administrasi/mutasi_barang/update', 'AdmMutasiBarangController@update')->name('update-mutasi');
		Route::post('administrasi/mutasi_barang/get_data', 'AdmMutasiBarangController@get_data')->name('get-data-mutasi');
		Route::get('administrasi/mutasi_barang/detail/{id}', 'AdmMutasiBarangController@detail');
		Route::get('administrasi/mutasi_barang/edit/{id}', 'AdmMutasiBarangController@edit');
		Route::get('administrasi/mutasi_barang/delete/{id}', 'AdmMutasiBarangController@delete');
		Route::post('administrasi/mutasi_barang/terima_mutasi', 'AdmMutasiBarangController@acc_mutasi')->name('terima-data-mutasi');

		// END ADM MUTASI

		// ADM MAINTENANCE

		Route::get('administrasi/maintenance_barang', 'AdmMaintenanceController@index')->name('adm-maintenance-barang');
		Route::post('administrasi/maintenance_barang/simpan', 'AdmMaintenanceController@store')->name('simpan-maintenance');
		Route::post('administrasi/maintenance_barang/update', 'AdmMaintenanceController@update')->name('update-maintenance');
		Route::post('administrasi/maintenance_barang/get_data', 'AdmMaintenanceController@get_data')->name('get-data-maintenance');
		Route::get('administrasi/maintenance_barang/detail/{id}', 'AdmMaintenanceController@detail');
		Route::get('administrasi/maintenance_barang/edit/{id}', 'AdmMaintenanceController@edit');
		Route::get('administrasi/maintenance_barang/delete/{id}', 'AdmMaintenanceController@delete');

		// END ADM MAINTENANCE

		// ADM PELAPORAN

		Route::get('administrasi/pelaporan_barang', 'AdmPelaporanController@index')->name('adm-pelaporan-barang');
		Route::post('administrasi/pelaporan_barang/simpan', 'AdmPelaporanController@store')->name('simpan-laporan');
		Route::post('administrasi/pelaporan_barang/update', 'AdmPelaporanController@update')->name('update-laporan');
		Route::post('administrasi/pelaporan_barang/get_data', 'AdmPelaporanController@get_data')->name('get-data-pelaporan');
		Route::get('administrasi/pelaporan_barang/proses/{id}', 'AdmPelaporanController@proses');
		Route::get('administrasi/pelaporan_barang/detail/{id}', 'AdmPelaporanController@detail');
		Route::get('administrasi/pelaporan_barang/jawab/{id}', 'AdmPelaporanController@jawab');
		Route::get('administrasi/pelaporan_barang/edit/{id}', 'AdmPelaporanController@edit');
		Route::get('administrasi/pelaporan_barang/delete/{id}', 'AdmPelaporanController@delete');
		Route::post('administrasi/pelaporan_barang/simpan_jawaban_laporan', 'AdmPelaporanController@store_jawaban')->name('simpan-jawaban-laporan');

		// END ADM PELAPORAN

		// SYSTEM

		Route::get('system/users', 'UserController@index')->name('users');
		Route::get('system/users/get_data', 'UserController@get_data')->name('get-data-user');
		Route::post('system/users/simpan', 'UserController@store')->name('simpan-user');
		Route::get('system/users/edit/{id}', 'UserController@edit_index');
		Route::get('system/users/akses/{id}', 'UserController@akses_index');
		Route::get('system/users/detail/{id}', 'UserController@detail_index');
		Route::post('system/users/update', 'UserController@update')->name('update-user');
		Route::get('system/users/delete/{id}', 'UserController@delete');
		Route::post('system/user/store_akses', 'UserController@save_access')->name('simpan-akses');

		Route::get('system/my_account', 'UserController@myacc_index')->name('my-acc');
		Route::post('system/my_account/update', 'UserController@myacc_update')->name('update-myacc');

		Route::get('system/logActivity', 'LogController@index')->name('logs');
		Route::post('system/logActivity/get_data', 'LogController@get_data')->name('get-data-log');

		// END SYSTEM

		// LAPORAN

		Route::get('laporan/barang', 'LaporanController@index')->name('laporan-barang');
		Route::get('laporan/barang/kategori/{id}', 'LaporanController@get_laporan_kategori_barang');

		// END OF LAPORAN


	// END OF ADMIN ACCESS

	Route::get('landing_admin', 'AdminController@index')->name('landing-admin');

	// DASHBOARD

	Route::get('dashboard/get_data_selected/{id}', 'AdminController@load_selected_lokasi');
	Route::get('dashboard/administration_summary', 'AdminController@load_adm')->name('load-adm-summary');
	Route::get('dashboard/master_summary', 'AdminController@load_master')->name('load-master-summary');
	Route::get('dashboard/chart_asset', 'AdminController@load_chart_asset')->name('load-chart-asset');
	Route::get('dashboard/pin_requester', 'AdminController@load_pin_requester')->name('load-pin');

	// END OF DASHBOARD
});