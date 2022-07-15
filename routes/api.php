<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/login', 'api\AuthController@login')->name('login');
Route::middleware('jwt.verify')->get('v1/dashboard', 'api\BarangController@dashboard')->name('dashboard');
Route::middleware('jwt.verify')->get('v1/barang_lokasi', 'api\BarangController@barang_lokasi')->name('barang_lokasi');
Route::middleware('jwt.verify')->get('v1/get_user', 'api\AuthController@getUser')->name('get_user');
// Route::middleware('jwt.verify')->post('v1/refresh', 'api\AuthController@refresh')->name('refresh');
Route::post('v1/refresh', 'api\AuthController@refresh')->name('refresh');
Route::middleware('jwt.verify')->post('v1/scan', 'api\BarangController@scan')->name('scan');
Route::middleware('jwt.verify')->post('v1/laporan', 'api\LaporanController@laporan')->name('laporan');
Route::middleware('jwt.verify')->get('v1/histori_laporan', 'api\LaporanController@histori_laporan')->name('histori_laporan');


Route::middleware('jwt.auth')->get('users', function () {
    return auth('api')->user();
});
