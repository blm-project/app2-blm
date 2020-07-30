<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});



//FA-REPORT
Route::get('export-bukubesar', ['as' => 'export-bukubesar', 'uses' => 'AdminBukuBesarController@ExportBukuBesar']);
Route::get('export-neraca', ['as' => 'export-neraca', 'uses' => 'AdminNeracaLajurController@ExportNeraca']);
Route::get('export-labarugi', ['as' => 'export-labarugi', 'uses' => 'AdminLabarugiController@ExportLabarugi']);


//print-route
Route::get('admin/quotation/print-quot/{id}','AdminQuotationController@generatePDF');
