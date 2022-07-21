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

Route::get('register', 'AuthController@showRegister');
Route::post('register', 'AuthController@register')->name('register');

Route::get('lupa_password', 'AuthController@showLupaPassword');
Route::post('lupa_password', 'AuthController@lupa_password')->name('lupa_password');
Route::get('lupa_password/verif', 'AuthController@verif_kode')->name('verif');
Route::post('lupa_password/kode_verif', 'AuthController@kode_verif')->name('kode_verif');

Route::get('lupa_password/verif_final', 'AuthController@verif_final')->name('verif_final');
Route::post('lupa_password/verif_final', 'AuthController@verif_final_execute');

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

		// STOK OPNAME

		Route::get('transaksi/stok_opname', 'StokOpNameController@index')->name('stok-opname');
		Route::post('transaksi/stok_opname/store', 'StokOpNameController@store')->name('simpan-stokopname');
		Route::get('transaksi/stok_opname/delete/{id}', 'StokOpNameController@delete');
		Route::get('transaksi/stok_opname/get_detail/{id}', 'StokOpNameController@detail');

		// END STOK OPNAME

		// LAPORAN

		Route::get('laporan/barang', 'LaporanController@index')->name('laporan-barang');
		Route::post('laporan/get_data_penjualan', 'LaporanController@get_penjualan')->name('get-laporan-barang');
		Route::get('laporan/barang/kategori/{id}', 'LaporanController@get_laporan_kategori_barang');
		Route::post('laporan/get_list_transaksi', 'LaporanController@get_list_transaksi');

		Route::get('laporan/stok_opname', 'LaporanController@index_opname')->name('laporan-opname');
		Route::get('laporan/po', 'LaporanController@index_po')->name('laporan-po');

		// END OF LAPORAN


	// END OF ADMIN ACCESS

	Route::get('landing_admin', 'AdminController@index')->name('landing-admin');
	Route::get('dashboard/get_data/{id1}/{id2}', 'AdminController@get_data');

	// DASHBOARD


	// END OF DASHBOARD
});