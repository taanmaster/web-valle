<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    /* Portal Ciudadanos */
    Route::get('/', 'FrontController@index')->name('index');

    Route::get('/en-construccion', 'FrontController@building')->name('building');

    // Módulo Gaceta Municipal
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
        'uses' => 'FrontController@filterGazetteByDate',
        'as' => 'gazette.filter',
    ])->where('date', '[0-9]{4}-[0-9]{2}');

    // Módulo Transparencia
    Route::get('/transparencia/dependencias', [
        'uses' => 'FrontController@dependencyList',
        'as' => 'dependency.list',
    ]);

    Route::get('/transparencia/dependencias/{slug}', [
        'uses' => 'FrontController@dependencyDetail',
        'as' => 'dependency.detail',
    ])->where('slug', '[\w\d\-\_]+');

    Route::get('/transparencia/obligaciones/{slug}', [
        'uses' => 'FrontController@obligationDetail',
        'as' => 'obligation.detail',
    ])->where('slug', '[\w\d\-\_]+');

    Route::get('/filtrar-documentos/{slug}/{date}', [
        'uses' => 'FrontController@filterTransparencyDocumentByDate',
        'as' => 'document.filter',
    ])->where('date', '[0-9]{4}');

    /*
    Route::get('/transparencia/documentos/{slug}', [
        'uses' => 'FrontController@documentDetail',
        'as' => 'document.detail',
    ])->where('slug', '[\w\d\-\_]+');
    */

    // Módulo Textos Legales
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

        /* Ciudadanos */
        Route::resource('citizens', CitizenController::class);
        Route::resource('citizen_files', CitizenFileController::class);

        Route::get('/citizens/funciones/busqueda', [
            'uses' => 'SearchController@citizenQuery',
            'as' => 'back.citizens.query',
        ]);

        /* Apoyos Económicos */
        Route::resource('financial_supports', FinancialSupportController::class);
        
        Route::get('/financial_supports/funciones/busqueda', [
            'uses' => 'SearchController@financial_supportsQuery',
            'as' => 'back.financial_supports.query',
        ]);

        Route::get('/financial_supports/funciones/apoyos-del-dia', [
            'uses' => 'FinancialSupportController@todayQuery',
            'as' => 'report.query',
        ]);

        Route::get('/financial_supports/funciones/reporte-grafico', [
            'uses' => 'FinancialSupportController@reportQuery',
            'as' => 'kpi.query',
        ]);

        /* Tipos de Apoyo Económico */
        Route::resource('financial_support_types', FinancialSupportTypeController::class);

        Route::get('/financial_support_types/funciones/busqueda', [
            'uses' => 'SearchController@financial_support_typesQuery',
            'as' => 'back.financial_support_types.query',
        ]);

        /* Generador de Documentación */
        Route::post('/financial_supports/{id}/download-gratefulness',[
            'uses' => 'FinancialSupportController@downloadGratefulness',
            'as' => 'financial_supports.downloadGratefulness',
        ]);

        Route::post('/financial_supports/{id}/download-request',[
            'uses' => 'FinancialSupportController@downloadRequest',
            'as' => 'financial_supports.downloadRequest',
        ]);

        Route::post('/financial_supports/{id}/download-support-receipt',[
            'uses' => 'FinancialSupportController@downloadSupportReceipt',
            'as' => 'financial_supports.downloadSupportReceipt',
        ]);

        Route::post('/financial_supports/{id}/download-under-oath',[
            'uses' => 'FinancialSupportController@downloadUnderOath',
            'as' => 'financial_supports.downloadUnderOath',
        ]);

        Route::post('/financial_supports/{id}/download-received',[
            'uses' => 'FinancialSupportController@downloadReceived',
            'as' => 'financial_supports.downloadReceived',
        ]);

        Route::post('/financial_supports/download-cash-cut',[
            'uses' => 'FinancialSupportController@downloadCashCut',
            'as' => 'financial_supports.downloadCashCut',
        ]);

        /* Transaparencia */
        Route::group(['prefix' => 'transparency'], function(){
            Route::resource('dependencies', TransparencyDependencyController::class)->names([
                'index' => 'transparency_dependencies.index',
                'create' => 'transparency_dependencies.create',
                'store' => 'transparency_dependencies.store',
                'show' => 'transparency_dependencies.show',
                'edit' => 'transparency_dependencies.edit',
                'update' => 'transparency_dependencies.update',
                'destroy' => 'transparency_dependencies.destroy',
            ]);

            Route::resource('obligations', TransparencyObligationController::class)->names([
                'index' => 'transparency_obligations.index',
                'create' => 'transparency_obligations.create',
                'store' => 'transparency_obligations.store',
                'show' => 'transparency_obligations.show',
                'edit' => 'transparency_obligations.edit',
                'update' => 'transparency_obligations.update',
                'destroy' => 'transparency_obligations.destroy',
            ]);

            Route::resource('documents', TransparencyDocumentController::class)->names([
                'index' => 'transparency_documents.index',
                'create' => 'transparency_documents.create',
                'store' => 'transparency_documents.store',
                'show' => 'transparency_documents.show',
                'edit' => 'transparency_documents.edit',
                'update' => 'transparency_documents.update',
                'destroy' => 'transparency_documents.destroy',
            ]);

            Route::resource('files', TransparencyFileController::class)->names([
                'index' => 'transparency_files.index',
                'create' => 'transparency_files.create',
                'store' => 'transparency_files.store',
                'show' => 'transparency_files.show',
                'edit' => 'transparency_files.edit',
                'update' => 'transparency_files.update',
                'destroy' => 'transparency_files.destroy',
            ]);

            Route::resource('dependency_users', TransparencyDependencyUserController::class)->names([
                'index' => 'transparency_dependency_users.index',
                'create' => 'transparency_dependency_users.create',
                'store' => 'transparency_dependency_users.store',
                'show' => 'transparency_dependency_users.show',
                'edit' => 'transparency_dependency_users.edit',
                'update' => 'transparency_dependency_users.update',
                'destroy' => 'transparency_dependency_users.destroy',
            ]);

            /* Repositorio funciones Asincronas */
            Route::post('dropzone/upload/{id}', 'TransparencyFileController@uploadFile')->name('dropzone.upload');
            Route::get('dropzone/fetch/{id}', 'TransparencyFileController@fetchFile')->name('dropzone.fetch');
            Route::get('dropzone/delete/{id}', 'TransparencyFileController@deleteFile')->name('dropzone.delete');
        });
    });
});

