<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::namespace('App\Http\Controllers')->group(function () {
    /* Portal Ciudadanos */
    Route::get('/', 'FrontController@index')->name('index');

    Route::get('/en-construccion', 'FrontController@building')->name('building');

    Route::get('/gaceta-municipal/{type}', [
        'uses' => 'FrontController@gazetteList',
        'as' => 'gazette.list',
    ]);

    Route::get('/gaceta-municipal/{type}/{slug}', [
        'uses' => 'FrontController@gazetteDetail',
        'as' => 'gazette.detail',
    ])->where('slug', '[\w\d\-\_]+');

    Route::get('/busqueda-general/gaceta-municipal', [
        'uses' => 'FrontController@gazetteQuery',
        'as' => 'front.gazette.query',
    ]);

    Route::get('/filtrar/gaceta-municipal/{type}/{date}', [
        'uses' => 'FrontController@filterByDate',
        'as' => 'gazette.filter',
    ])->where('date', '[0-9]{4}-[0-9]{2}');

    Route::get('/informacion-legal/{slug}', 'FrontController@legalText')->name('legal.text');

    //Route::get('{any}', 'DashboardController@index')->name('index');

    // Back-End Views
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'can:admin_access']], function(){
        Route::get('/', 'DashboardController@index')->name('dashboard');

        /* Usuarios */
        Route::resource('users', UserController::class);
        
        Route::get('profile', [
            'uses' => 'DashboardController@adminProfile',
            'as' => 'admin.profile',
        ]);

        Route::get('configurations', [
            'uses' => 'DashboardController@adminConfig',
            'as' => 'admin.config',
        ]);

        /* Textos Legales */
        Route::resource('legals', LegalTextController::class);

        /* Gaceta Municipal */
        Route::resource('gazettes', GazetteController::class);
        Route::resource('gazette_files', GazetteFileController::class);

        Route::get('/gaceta-municipal/funciones/busqueda', [
            'uses' => 'SearchController@gazetteQuery',
            'as' => 'back.gazette.query',
        ]);
    });
});

