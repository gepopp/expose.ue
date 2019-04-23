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


Route::post('file/{folder}', 'FileController@store');
Route::post('file/{folder}/{uploadable}/{uploaableid}', 'FileController@store');
Route::delete('file/{file}', 'FileController@destroy');
Route::put('file/{file}', 'FileController@update');



Route::get('/home', 'HomeController@index')->name('home');

Route::resource('meta', 'ObjektMetaController')->middleware('auth');
Route::get('metasort', 'ObjektMetaController@sort')->middleware('auth')->name('meta.sort');
Route::resource('realestate', 'RealEstateController')->middleware('auth');

Route::get('/realestate/{realEstate}/realEstateGallery/create', 'RealEstateGalleryController@create' )->middleware('auth')->name('creategallery');
Route::get('/realestate/{realEstate}/realEstateGallery', 'RealEstateGalleryController@index' )->middleware('auth')->name('galleries');
Route::post('/realestate/{realEstate}/realEstateGallery/store', 'RealEstateGalleryController@store' )->middleware('auth')->name('storegallery');
Route::get('/realestate/{realEstate}/realEstateGallery/{realEstateGallery}/edit', 'RealEstateGalleryController@edit' )->middleware('auth')->name('editgallery');

Route::get('/realestate/{realEstate}/realEstateGallery/{realEstateGallery}/sort', 'RealEstateGalleryController@sortAndLabel' )->middleware('auth')->name('gallery.sort');

Route::put('/realestate/{realEstate}/realEstateGallery/{realEstateGallery}/update', 'RealEstateGalleryController@update' )->middleware('auth')->name('updategallery');

Route::delete('/realestate/{realEstate}/realEstateGallery/{realEstateGallery}/delete', 'RealEstateGalleryController@destroy' )->middleware('auth')->name('deletegallery');

Route::post('/sort/gallery', 'FileController@sort')->middleware('auth');


Route::get('titlepage/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\TitlepagePDF($realestate);
    $pdf->get();
})->name('titlepage');

Route::get('titlepageh/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\TitlepagePDFhorizontal($realestate);
    $pdf->get();
})->name('titlepageh');

Route::get('titlepages/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\TitlepagePDFLogoSmall($realestate);
    $pdf->get();
})->name('titlepages');


Route::get('descriptionpage/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\ObjectDescription($realestate);
    $pdf->get();
})->name('desc');
