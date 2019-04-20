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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('meta', 'ObjektMetaController')->middleware('auth');
Route::get('metasort', 'ObjektMetaController@sort')->middleware('auth')->name('meta.sort');
Route::resource('realestate', 'RealEstateController')->middleware('auth');


Route::get('titlepage/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\TitlepagePDF($realestate);
    $pdf->get();
})->name('titlepage');

Route::get('titlepageh/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\TitlepagePDFhorizontal($realestate);
    $pdf->get();
})->name('titlepageh');

Route::get('descriptionpage/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\ObjectDescription($realestate);
    $pdf->get();
})->name('desc');
