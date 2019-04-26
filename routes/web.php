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

use App\pdf\LocationPage;
use App\pdf\MetaPage;
use App\pdf\ObjectDescription;

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');


/** File upload, delete, label and sort */
Route::post('file/{folder}', 'FileController@store');
Route::post('file/{folder}/{uploadable}/{uploaableid}', 'FileController@store');
Route::delete('file/{file}', 'FileController@destroy');
Route::put('file/{file}', 'FileController@update');

/** Meta Route */
Route::resource('meta', 'ObjektMetaController')->middleware('auth');
Route::get('metasort', 'ObjektMetaController@sort')->middleware('auth')->name('meta.sort');


/** Real Estate */
Route::resource('realestate', 'RealEstateController')->middleware('auth');


/** Image Galleries */
Route::get('/realestate/{realEstate}/realEstateGallery/create', 'RealEstateGalleryController@create' )->middleware('auth')->name('creategallery');
Route::get('/realestate/{realEstate}/realEstateGallery', 'RealEstateGalleryController@index' )->middleware('auth')->name('galleries');
Route::post('/realestate/{realEstate}/realEstateGallery/store', 'RealEstateGalleryController@store' )->middleware('auth')->name('storegallery');
Route::get('/realestate/{realEstate}/realEstateGallery/{realEstateGallery}/edit', 'RealEstateGalleryController@edit' )->middleware('auth')->name('editgallery');
Route::get('/realestate/{realEstate}/realEstateGallery/{realEstateGallery}/sort', 'RealEstateGalleryController@sortAndLabel' )->middleware('auth')->name('gallery.sort');
Route::put('/realestate/{realEstate}/realEstateGallery/{realEstateGallery}/update', 'RealEstateGalleryController@update' )->middleware('auth')->name('updategallery');
Route::delete('/realestate/{realEstate}/realEstateGallery/{realEstateGallery}/delete', 'RealEstateGalleryController@destroy' )->middleware('auth')->name('deletegallery');
Route::post('/sort/gallery', 'FileController@sort')->middleware('auth');

/** Metadata */
Route::get('realestate/{realEstate}/realEstateMeta', 'RealEstateMetaController@index')->middleware('auth')->name('realestate.meta.index');
Route::get('realestate/{realEstate}/realEstateMeta/create', 'RealEstateMetaController@create')->middleware('auth')->name('realestate.meta.create');
Route::post('realestate/{realEstate}/realEstateMeta', 'RealEstateMetaController@store')->middleware('auth')->name('realestate.meta.store');
Route::post('realestate/{realEstate}/realEstateMeta/{realEstateMeta}/sort', 'RealEstateMetaController@sort')->middleware('auth')->name('realestate.meta.sort');
Route::get('realestate/{realEstate}/realEstateMeta/{realEstateMeta}/edit', 'RealEstateMetaController@edit')->middleware('auth')->name('realestate.meta.edit');
Route::put('realestate/{realEstate}/realEstateMeta/{realEstateMeta}', 'RealEstateMetaController@update')->middleware('auth')->name('realestate.meta.update');
Route::delete('realestate/{realEstate}/realEstateMeta/{realEstateMeta}', 'RealEstateMetaController@destroy')->middleware('auth')->name('realestate.meta.destroy');

/** Real Estate Text */
Route::get('realestate/{realEstate}/realEstateText', 'RealEstateTextController@index')->middleware('auth')->name('realestate.text.index');
Route::get('realestate/{realEstate}/realEstateText/create', 'RealEstateTextController@create')->middleware('auth')->name('realestate.text.create');
Route::post('realestate/{realEstate}/realEstateText', 'RealEstateTextController@store')->middleware('auth')->name('realestate.text.store');
Route::get('realestate/{realEstate}/realEstateText/{realEstateText}/edit', 'RealEstateTextController@edit')->middleware('auth')->name('realestate.text.edit');
Route::put('realestate/{realEstate}/realEstateText/{realEstateText}', 'RealEstateTextController@update')->middleware('auth')->name('realestate.text.update');
Route::delete('realestate/{realEstate}/realEstateText/{realEstateText}', 'RealEstateTextController@destroy')->middleware('auth')->name('realestate.text.destroy');

/** Real Estate Location */
Route::get('realestate/{realEstate}/realEstateLocation', 'RealEstateLocationController@index')->middleware('auth')->name('realestate.location.index');
Route::get('realestate/{realEstate}/realEstateLocation/create', 'RealEstateLocationController@create')->middleware('auth')->name('realestate.location.create');
Route::post('realestate/{realEstate}/realEstateLocation', 'RealEstateLocationController@store')->middleware('auth')->name('realestate.location.store');
Route::get('realestate/{realEstate}/realEstateLocation/{realEstateLocation}/edit', 'RealEstateLocationController@edit')->middleware('auth')->name('realestate.location.edit');
Route::put('realestate/{realEstate}/realEstateLocation/{realEstateLocation}', 'RealEstateLocationController@update')->middleware('auth')->name('realestate.location.update');
Route::delete('realestate/{realEstate}/realEstateLocation/{realEstateLocation}', 'RealEstateLocationController@destroy')->middleware('auth')->name('realestate.location.destroy');

/** Real Estate Address */
Route::get('realestate/{realEstate}/realEstateAddress', 'RealEstateAddressController@index')->middleware('auth')->name('realestate.address.index');
Route::get('realestate/{realEstate}/realEstateAddress/create', 'RealEstateAddressController@create')->middleware('auth')->name('realestate.address.create');
Route::post('realestate/{realEstate}/realEstateAddress', 'RealEstateAddressController@store')->middleware('auth')->name('realestate.address.store');
Route::get('realestate/{realEstate}/realEstateAddress/{realEstateAddress}/edit', 'RealEstateAddressController@edit')->middleware('auth')->name('realestate.address.edit');
Route::put('realestate/{realEstate}/realEstateAddress/{realEstateAddress}', 'RealEstateAddressController@update')->middleware('auth')->name('realestate.address.update');
Route::delete('realestate/{realEstate}/realEstateAddress/{realEstateAddress}', 'RealEstateAddressController@destroy')->middleware('auth')->name('realestate.address.destroy');




/** PDF */
Route::get('pdfSortSelect', '\App\pdf\creator\PDFCreator@sortnselect')->name('pdfcreator');



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

Route::get('metapage/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\MetaPage($realestate);
    $pdf->get();
})->name('meta');
Route::get('textpage/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\TextPage($realestate);
    $pdf->get();
})->name('text');
Route::get('locationPage/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\LocationPage($realestate);
    $pdf->get();
})->name('location');

Route::get('galleryPage/{realestate}', function (\App\RealEstate $realestate){

    $pdf = new App\pdf\ImagePage($realestate);
    $pdf->get();
})->name('gallery');
