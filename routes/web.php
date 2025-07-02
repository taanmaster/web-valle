<?php

use App\Http\Controllers\RegulatoryAgendaController;
use App\Http\Controllers\RegulatoryAgendaDependencyController;
use App\Http\Controllers\TsrAdminRevenueColletionArticleController;
use App\Http\Controllers\TsrAdminRevenueColletionFractionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TsrBillingAccountController;
use App\Models\TsrAdminRevenueColletionArticle;
use App\Models\TsrAdminRevenueColletionFraction;
use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    /* Portal Ciudadanos */
    Route::get('/', 'FrontController@index')->name('index');

    Route::get('/en-construccion', 'FrontController@building')->name('building');

    //Route::get('/mod-tesoreria', 'FrontController@treasury')->name('treasury.list');

    /*SARE*/
    Route::get('/sare', 'FrontController@sare')->name('sare.index');

    // Contraloría
    Route::get('/contraloria', 'FrontController@contraloria')->name('contraloria.index');
    Route::get('/contraloria/faltas-administrativas', 'FrontController@contraloriaFaults')->name('contraloria.faults');
    Route::get('/contraloria/faltas-administrativas/no-graves', 'FrontController@contraloriaFaultsNotSerious')->name('contraloria.faults.not-serious');
    Route::get('/contraloria/faltas-administrativas/sanciones-faltas-no-graves', 'FrontController@contraloriaFaultsNotSeriousRules')->name('contraloria.faults.not-serious-rules');
    Route::get('/contraloria/faltas-administrativas/graves', 'FrontController@contraloriaFaultsSerious')->name('contraloria.faults.serious');

    /*Denuncia NET*/
    Route::get('/denuncia-net', 'FrontController@denunciaNet')->name('denuncia.net');

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
    Route::get('/unidad-de-transparencia-y-acceso-a-la-informacion', [
        'uses' => 'FrontController@transparencyIndex',
        'as' => 'transparency.index',
    ]);

    Route::get('/unidad-de-transparencia-y-acceso-a-la-informacion/obligaciones/{type}', [
        'uses' => 'FrontController@transparencyObligations',
        'as' => 'transparency.obligations',
    ]);

    Route::get('/dependencias', [
        'uses' => 'FrontController@dependencyList',
        'as' => 'dependency.list',
    ]);

    Route::get('/tesoreria/dependencias', [
        'uses' => 'FrontController@treasuryDependencyList',
        'as' => 'treasury.dependency.list',
    ]);

    Route::get('/dependencias/{slug}', [
        'uses' => 'FrontController@dependencyDetail',
        'as' => 'dependency.detail',
    ])->where('slug', '[\w\d\-\_]+');

    Route::get('/obligaciones/{dependency}/{slug}', [
        'uses' => 'FrontController@obligationDetail',
        'as' => 'obligation.detail',
    ])->where('slug', '[\w\d\-\_]+');

    Route::get('/filtrar-documentos/{dependency}/{slug}/{date}', [
        'uses' => 'FrontController@filterTransparencyDocumentByDate',
        'as' => 'document.filter',
    ])->where('date', '[0-9]{4}');

    Route::get('/agenda-regulatoria', [
        'uses' => 'FrontController@regulatoryAgenda',
        'as' => 'regulatory-agenda.index'
    ]);

    Route::get('/agenda-regulatoria/dependencia/{id}', [
        'uses' => 'FrontController@regulatoryAgendaDependency',
        'as' => 'regulatory-agenda-dependency.show'
    ]);

    // Modulo Blog
    Route::get('/blog', [
        'uses' => 'FrontController@blog',
        'as' => 'blog.index',
    ]);

    Route::get('/blog/lista/{category}', [
        'uses' => 'FrontController@blogList',
        'as' => 'blog.list-filter',
    ]);

    Route::get('/blog/todos', [
        'uses' => 'FrontController@blogAll',
        'as' => 'blog.list',
    ]);

    Route::get('/blog/{slug}', [
        'uses' => 'FrontController@blogDetail',
        'as' => 'blog.detail',
    ])->where('slug', '[\w\d\-\_]+');
    /*
    Route::get('/transparencia/documentos/{slug}', [
        'uses' => 'FrontController@documentDetail',
        'as' => 'document.detail',
    ])->where('slug', '[\w\d\-\_]+');
    */

    // Módulo Textos Legales
    Route::get('/informacion-legal/{slug}', 'FrontController@legalText')->name('legal.text');

    //Route::get('{any}', 'DashboardController@index')->name('index');

    /* ------------------- */
    /* ------------------- */

    // Back-End Views
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'can:admin_access']], function () {
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

        /* Comunicación Social */
        Route::resource('banners', BannerController::class);

        Route::post('/banners/status/{id}', [
            'uses' => 'BannerController@status',
            'as' => 'banners.status',
        ]);

        Route::resource('headerbands', HeaderbandController::class);

        Route::post('/headerbands/status/{id}', [
            'uses' => 'HeaderbandController@status',
            'as' => 'headerbands.status',
        ]);

        Route::resource('popups', PopupController::class);

        Route::post('/popups/status/{id}', [
            'uses' => 'PopupController@status',
            'as' => 'popups.status',
        ]);

        Route::resource('events', EventController::class);

        Route::post('/events/status/{id}', [
            'uses' => 'EventController@status',
            'as' => 'events.status',
        ]);

        /* ------------------- */
        /* ------------------- */

        /* Textos Legales */
        Route::resource('legals', LegalTextController::class);

        /* ------------------- */
        /* ------------------- */

        /* Gaceta Municipal */
        Route::resource('gazettes', GazetteController::class);
        Route::resource('gazette_files', GazetteFileController::class);
        
        // Rutas para subida por chunks
        Route::post('/gazettes/init-chunk-upload', [
            'uses' => 'GazetteController@initChunkUpload',
            'as' => 'gazettes.init-chunk-upload',
        ]);
        
        Route::post('/gazettes/upload-chunk', [
            'uses' => 'GazetteController@uploadChunk',
            'as' => 'gazettes.upload-chunk',
        ]);
        
        Route::post('/gazettes/finalize-chunk-upload', [
            'uses' => 'GazetteController@finalizeChunkUpload',
            'as' => 'gazettes.finalize-chunk-upload',
        ]);

        Route::get('/gaceta-municipal/funciones/busqueda', [
            'uses' => 'SearchController@gazetteQuery',
            'as' => 'back.gazette.query',
        ]);

        /* ------------------- */
        /* ------------------- */

        /* Ciudadanos */
        Route::resource('citizens', CitizenController::class);
        Route::resource('citizen_files', CitizenFileController::class);

        Route::get('/citizens/funciones/busqueda', [
            'uses' => 'SearchController@citizenQuery',
            'as' => 'back.citizens.query',
        ]);

        /* ------------------- */
        /* ------------------- */

        Route::put('/transparency_documents/{id}/deleteFile', [
            'uses' => 'TransparencyDocumentController@deleteFile',
            'as' => 'transparency_documents.deleteFile',
        ]);

        /* Transparencia */
        Route::group(['prefix' => 'transparency'], function () {
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

            // Rutas para subida por chunks de documentos de transparencia
            Route::post('/documents/init-chunk-upload', [
                'uses' => 'TransparencyDocumentController@initChunkUpload',
                'as' => 'transparency_documents.init-chunk-upload',
            ]);
            
            Route::post('/documents/upload-chunk', [
                'uses' => 'TransparencyDocumentController@uploadChunk',
                'as' => 'transparency_documents.upload-chunk',
            ]);
            
            Route::post('/documents/finalize-chunk-upload', [
                'uses' => 'TransparencyDocumentController@finalizeChunkUpload',
                'as' => 'transparency_documents.finalize-chunk-upload',
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

        /* ------------------- */
        /* ------------------- */

        /* Tesorería */
        Route::group(['prefix' => 'treasury'], function () {
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
            Route::post('/financial_supports/{id}/download-gratefulness', [
                'uses' => 'FinancialSupportController@downloadGratefulness',
                'as' => 'financial_supports.downloadGratefulness',
            ]);

            Route::post('/financial_supports/{id}/download-request', [
                'uses' => 'FinancialSupportController@downloadRequest',
                'as' => 'financial_supports.downloadRequest',
            ]);

            Route::post('/financial_supports/{id}/download-support-receipt', [
                'uses' => 'FinancialSupportController@downloadSupportReceipt',
                'as' => 'financial_supports.downloadSupportReceipt',
            ]);

            Route::post('/financial_supports/{id}/download-under-oath', [
                'uses' => 'FinancialSupportController@downloadUnderOath',
                'as' => 'financial_supports.downloadUnderOath',
            ]);

            Route::post('/financial_supports/{id}/download-received', [
                'uses' => 'FinancialSupportController@downloadReceived',
                'as' => 'financial_supports.downloadReceived',
            ]);

            Route::post('/financial_supports/download-cash-cut', [
                'uses' => 'FinancialSupportController@downloadCashCut',
                'as' => 'financial_supports.downloadCashCut',
            ]);

            /* ------------------- */
            /* ------------------- */

            /* Cuentas por Pagar */
            Route::resource('account_payable_suppliers', TreasuryAccountPayableSupplierController::class)->names([
                'index' => 'treasury_account_payable_suppliers.index',
                'create' => 'treasury_account_payable_suppliers.create',
                'store' => 'treasury_account_payable_suppliers.store',
                'show' => 'treasury_account_payable_suppliers.show',
                'edit' => 'treasury_account_payable_suppliers.edit',
                'update' => 'treasury_account_payable_suppliers.update',
                'destroy' => 'treasury_account_payable_suppliers.destroy',
            ]);

            Route::resource('account_payable_contractors', TreasuryAccountPayableContractorController::class)->names([
                'index' => 'treasury_account_payable_contractors.index',
                'create' => 'treasury_account_payable_contractors.create',
                'store' => 'treasury_account_payable_contractors.store',
                'show' => 'treasury_account_payable_contractors.show',
                'edit' => 'treasury_account_payable_contractors.edit',
                'update' => 'treasury_account_payable_contractors.update',
                'destroy' => 'treasury_account_payable_contractors.destroy',
            ]);

            Route::resource('account_payable_checklists', TreasuryAccountPayableChecklistController::class)->names([
                'index' => 'treasury_account_payable_checklists.index',
                'create' => 'treasury_account_payable_checklists.create',
                'store' => 'treasury_account_payable_checklists.store',
                'show' => 'treasury_account_payable_checklists.show',
                'edit' => 'treasury_account_payable_checklists.edit',
                'update' => 'treasury_account_payable_checklists.update',
                'destroy' => 'treasury_account_payable_checklists.destroy',
            ]);

            Route::resource('checklist_elements', TreasuryAccountPayableChecklistElementController::class)->names([
                'store' => 'checklist_elements.store',
                'update' => 'checklist_elements.update',
                'destroy' => 'checklist_elements.destroy',
            ]);

            Route::resource('{supplier_id}/supplier_checklists', TreasuryAccountPayableSupplierChecklistController::class)->names([
                'index' => 'supplier_checklists.index',
                'create' => 'supplier_checklists.create',
                'store' => 'supplier_checklists.store',
                'show' => 'supplier_checklists.show',
                'edit' => 'supplier_checklists.edit',
                'update' => 'supplier_checklists.update',
                'destroy' => 'supplier_checklists.destroy',
            ]);

            /* Cuentas por Cobrar */
            Route::group(['prefix' => 'account_due'], function () {
                Route::get('dashboard', [
                    'uses' => 'TsrAccountsDueController@dashboard',
                    'as' => 'account_due.dashboard',
                ]);

                Route::get('cashbox', [
                    'uses' => 'TsrAccountsDueController@cashbox',
                    'as' => 'account_due.cashbox',
                ]);

                Route::resource('profiles', TsrAccountDueProfileController::class)->names([
                    'index' => 'account_due_profiles.index',
                    'create' => 'account_due_profiles.create',
                    'store' => 'account_due_profiles.store',
                    'show' => 'account_due_profiles.show',
                    'edit' => 'account_due_profiles.edit',
                    'update' => 'account_due_profiles.update',
                    'destroy' => 'account_due_profiles.destroy',
                ]);

                Route::resource('provisional_integers', TsrAccountDueProvisionalIntegerController::class)->names([
                    'index' => 'account_due_provisional_integers.index',
                    'create' => 'account_due_provisional_integers.create',
                    'store' => 'account_due_provisional_integers.store',
                    'show' => 'account_due_provisional_integers.show',
                    'edit' => 'account_due_provisional_integers.edit',
                    'update' => 'account_due_provisional_integers.update',
                    'destroy' => 'account_due_provisional_integers.destroy',
                ]);

                Route::get('/provisional_integers/print/{id}', [
                    'uses' => 'TsrAccountsDueController@printInteger',
                    'as' => 'account_due_provisional_integers.print',
                ]);

                Route::resource('incomes', TsrAccountDueIncomeController::class)->names([
                    'index' => 'account_due_incomes.index',
                    'create' => 'account_due_incomes.create',
                    'store' => 'account_due_incomes.store',
                    'show' => 'account_due_incomes.show',
                    'edit' => 'account_due_incomes.edit',
                    'update' => 'account_due_incomes.update',
                    'destroy' => 'account_due_incomes.destroy',
                ]);

                Route::get('/income/closed/{id}', [
                    'uses' => 'TsrAccountDueIncomeController@close',
                    'as' => 'account_due_incomes.close',
                ]);

                Route::resource('income_receipts', TsrAccountDueIncomeReceiptController::class)->names([
                    'index' => 'account_due_income_receipts.index',
                    'destroy' => 'account_due_income_receipts.destroy',
                ]);

                Route::get('/income_receipts/{id}/create', [
                    'uses' => 'TsrAccountDueIncomeReceiptController@create',
                    'as' => 'account_due_income_receipts.create',
                ]);

                Route::get('daily_cashier_report', [
                    'uses' => 'TsrAccountsDueController@dailyReport',
                    'as' => 'account_due.daily',
                ]);

                Route::get('/daily_cashier_report_export/{id}', [
                    'uses' => 'TsrAccountsDueController@exportDaily',
                    'as' => 'account_due_daily.export',
                ]);

                Route::get('cashier_report', [
                    'uses' => 'TsrAccountsDueController@report',
                    'as' => 'account_due.report',
                ]);

                Route::get('/cashier_report_export/{id}', [
                    'uses' => 'TsrAccountsDueController@exportCustome',
                    'as' => 'account_due_custome.export',
                ]);
            });

            /*Generador de Cajas para Tesorería*/
            Route::resource('cashiers', TsrCashierController::class)->names([
                'store' => 'tsr_cashiers.store',
                'update' => 'tsr_cashiers.update',
                'destroy' => 'tsr_cashiers.destroy',
            ]);


            /* Generador de Documentación */
            Route::post('/supplier_checklists/{id}/download-Checklist', [
                'uses' => 'TreasuryAccountPayableSupplierChecklistController@downloadChecklist',
                'as' => 'supplier_checklists.download',
            ]);

            Route::resource('{contractor_id}/contractor_checklists', TreasuryAccountPayableContractorChecklistController::class)->names([
                'index' => 'contractor_checklists.index',
                'create' => 'contractor_checklists.create',
                'store' => 'contractor_checklists.store',
                'show' => 'contractor_checklists.show',
                'edit' => 'contractor_checklists.edit',
                'update' => 'contractor_checklists.update',
                'destroy' => 'contractor_checklists.destroy',
            ]);

            /* Generador de Documentación */
            Route::post('/contractor_checklists/{id}/download-Checklist', [
                'uses' => 'TreasuryAccountPayableContractorChecklistController@downloadChecklist',
                'as' => 'contractor_checklists.download',
            ]);

            Route::resource('supplier_checklist_authorizations', TreasuryAccountPayableSupplierChecklistAutorizationController::class)->names([
                'store' => 'supplier_checklist_authorizations.store',
                'update' => 'supplier_checklist_authorizations.update',
                'destroy' => 'supplier_checklist_authorizations.destroy',
            ]);

            /* ------------------- */
            /* ------------------- */

            /* Disposiciones Administrativas de Recaudación */
            Route::resource('revenue_collection', TsrAdminRevenueCollectionController::class)->names([
                'index' => 'trs_admin_revenue_collection.index',
                'show' => 'trs_admin_revenue_collection.show',
            ]);

            /* Disposiciones Administrativas de Recaudación -- Secciones*/
            Route::resource('revenue_collection_sections', TsrAdminRevenueColletionSectionController::class)->names([
                'destroy' => 'revenue_collection_sections.destroy',
            ]);

            /* Disposiciones Administrativas de Recaudación -- Articulos*/
            Route::resource('revenue_collection_articles', TsrAdminRevenueColletionArticleController::class)->names([
                'destroy' => 'revenue_collection_articles.destroy'
            ]);

            /* Disposiciones Administrativas de Recaudación -- Fracciones*/
            Route::resource('revenue_collection_fractions', TsrAdminRevenueColletionFractionController::class)->names([
                'destroy' => 'revenue_collection_fractions.destroy'
            ]);

            /* Disposiciones Administrativas de Recaudación -- Incisos*/
            Route::resource('revenue_collection_clause', TsrAdminRevenueColletionClauseController::class)->names([
                'destroy' => 'revenue_collection_clauses.destroy'
            ]);

            /* Disposiciones Administrativas de Recaudación -- Variantes*/
            Route::resource('revenue_collection_variant', TsrAdminRevenueColletionVariantController::class)->names([
                'destroy' => 'revenue_collection_variants.destroy'
            ]);

            /* Ley de Ingresos */
            Route::resource('revenue_law', TsrRevenueLawController::class)->names([
                'index' => 'revenue_law.index',
                'show' => 'revenue_law.show',
            ]);

            /* Ley de Ingresos -- Ingresos */
            Route::resource('revenue_law_income', TsrRevenueLawIncomeController::class)->names([
                'destroy' => 'revenue_law_income.destroy'
            ]);

            /* Ley de Ingresos -- Conceptos */
            Route::resource('revenue_law_concept', TsrRevenueLawConceptController::class)->names([
                'destroy' => 'revenue_law_concept.destroy'
            ]);

            /* Tarifas y Costos */
            Route::resource('revenue_law_rates_and_fees', TsrRevenueLawRateAndFeeController::class)->names([
                'index' => 'rates_and_costs.index',
                'destroy' => 'rates_and_cost.destroy',
            ]);

            // Documentos y Dependencias
            Route::resource('dependencies', TreasuryDependencyController::class)->names([
                'index' => 'treasury_dependencies.index',
            ]);
        });

        /*Agenda regulatoria*/
        Route::resource('regulatory_agenda', RegulatoryAgendaController::class)->names([
            'index' => 'regulatory_agenda.index',
            'show' => 'regulatory_agenda.show',
        ]);

        Route::resource('regulatory_agenda_dependency', RegulatoryAgendaDependencyController::class)->names([
            'destroy' => 'regulatory_agenda_dependency.destroy'
        ]);

        Route::resource('regulatory_agenda_regulation', RegulatoryAgendaRegulationController::class)->names([
            'show' => 'regulatory_agenda_regulation.show',
        ]);

        Route::resource('regulatory_agenda_regulation', RegulatoryAgendaRegulationController::class)->names([
            'edit' => 'regulatory_agenda_regulation.edit',
        ]);

        Route::get('/regulatory_agenda_new/{id}', [
            'uses' => 'RegulatoryAgendaRegulationController@create',
            'as' => 'regulatory_agenda_regulation.create'
        ]);

        Route::resource('blogAmin', BlogController::class)->names([
            'index' => 'blog.admin.index',
            'show' => 'blog.admin.show',
            'edit' => 'blog.admin.edit',
            'create' => 'blog.admin.create',
            'destroy' => 'blog.admin.destroy',
        ]);

        /* Repositorio funciones Asincronas */
        Route::group(['prefix' => 'blogAdmin'], function () {
            Route::post('dropzone/upload/{id}', 'BlogController@uploadFile')->name('dropzone.blog.upload');
            Route::get('dropzone/fetch/{id}', 'BlogController@fetchFile')->name('dropzone.blog.fetch');
            Route::post('dropzone/delete/', 'BlogController@deleteFile')->name('dropzone.blog.delete');
        });

        /*Denuncia Ciudadana*/
        Route::get('/citizen-complain', [
            'uses' => 'CitizenComplainController@index',
            'as' => 'citizen_complain.index',
        ]);
    });
});
