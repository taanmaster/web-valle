<?php

// Controladores

// Agenda Regulatoria
use App\Http\Controllers\RegulatoryAgendaController;
use App\Http\Controllers\RegulatoryAgendaDependencyController;

// Comunicación Social
use App\Http\Controllers\BlogController;

// DIF
use App\Http\Controllers\CitizenMedicalProfileController;
use App\Http\Controllers\DIFReceiptController;
use App\Http\Controllers\DIFBannerController;
use App\Http\Controllers\DIFProgramController;
use App\Http\Controllers\DIFCoordinationController;
use App\Http\Controllers\DIFDoctorConsultController;
use App\Http\Controllers\DIFPrescriptionController;
use App\Http\Controllers\DIFPrescriptionFileController;
use App\Http\Controllers\DIFMedicationController;
use App\Http\Controllers\DIFMedicationVariantController;
use App\Http\Controllers\DIFStockMovementController;
use App\Http\Controllers\DIFExpenseController;
use App\Http\Controllers\DIFIncomeController;
use App\Http\Controllers\TapChecklistAuthorizationNoteController;
use App\Http\Controllers\TapSupplierLogController;

// Desarrollo Institucional
use App\Http\Controllers\InstitucionalDevelopmentBannerController;

// Tesorería
use App\Http\Controllers\TreasuryAccountPayableController;
use App\Http\Controllers\TsrBillingAccountController;
use App\Http\Controllers\TsrAdminRevenueColletionArticleController;
use App\Http\Controllers\TsrAdminRevenueColletionFractionController;

// Desarrollo Urbano
use App\Http\Controllers\UrbanDevRequestController;
use App\Http\Controllers\UrbanDevInspectorController;
use App\Http\Controllers\UrbanDevRequestNoteController;
use App\Http\Controllers\UrbanDevRequestFileController;
use App\Http\Controllers\UrbanDevWorkerController;
use App\Http\Controllers\UrbanDevKPIsController;

// Adquisiciones
use App\Http\Controllers\AcquisitionEndorsementController;
use App\Http\Controllers\AcquisitionApprovalController;
use App\Http\Controllers\AcquisitionMaterialController;
use App\Http\Controllers\AcquisitionSupplierController;
use App\Http\Controllers\BiddingContractController;
use App\Http\Controllers\BiddingController;
use App\Http\Controllers\SupplierBiddingController;
use App\Http\Controllers\SupplierMessageController;
use App\Http\Controllers\AcquisitionsInventoryController;
use App\Http\Controllers\AcquisitionsKPIsController;

// Modelos
use App\Models\InstitucionalDevelopmentBanner;
use App\Models\TsrAdminRevenueColletionArticle;
use App\Models\TsrAdminRevenueColletionFraction;
use App\Models\DIFIncome;

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(function () {
    /* Portal Ciudadanos */
    Route::get('/', 'FrontController@index')->name('index');
    Route::get('/en-construccion', 'FrontController@building')->name('building');

    //Route::get('/mod-tesoreria', 'FrontController@treasury')->name('treasury.list');

    //Registro Municipal de Inspecciones, Verificaciones y Visitas Domiciliarias
    Route::get('/registro-municipal-de-inspecciones', 'FrontController@municipalInspection')->name('inspeccion_municipal.index');

    //Integrantes del Consejo
    Route::get('/integrantes-del-consejo', 'FrontController@urbanCouncil')->name('urban_council.index');

    //Atribuciones del Consejo
    Route::get('/atribuciones-del-consejo', 'FrontController@councilAttributions')->name('council_attributions.index');

    //Actas de Consejo
    Route::get('/actas-de-consejo', 'FrontController@actasConsejo')->name('actas_consejo.index');

    //Instituto Municipal de Planeación
    Route::group(['prefix' => '/instituto-municipal-de-planeacion'], function () {
        Route::get('/', 'FrontController@implan')->name('implan.index');
        Route::get('/quienes-somos', 'FrontController@implanWhoWeAre')->name('implan.who_we_are');
        Route::get('/blog', 'FrontController@implanBlog')->name('implan.front.blog');
        Route::get('/blog/{slug}', 'FrontController@implanBlogDetail')->name('implan.front.blog.detail');
        Route::get('/proyectos', 'FrontController@implanProjects')->name('implan.front.projects');
        Route::get('/proyectos/{slug}', 'FrontController@implanProjectDetail')->name('implan.front.project.detail');
        Route::get('/logros', 'FrontController@implanAchievements')->name('implan.front.achievements');
    });

    // SARE
    Route::get('/sare', 'FrontController@sare')->name('sare.index');
    Route::get('/desarrollo_institucional', 'FrontController@desarrolloInstitucional')->name('desarrollo_institucional.index');
    Route::get('/registro_municipal_de_regulaciones', 'FrontController@registroMunicipalDeRegulaciones')->name('regulaciones_municipales.index');
    Route::get('/registro_municipal_de_regulaciones/{id}', 'FrontController@showRegulacion')->name('regulaciones_municipales.show');
    Route::get('/tramites_y_servicios', 'FrontController@tramitesYServicios')->name('tramites_y_servicios.index');
    Route::get('/tramites_y_servicios/{id}', 'FrontController@showTramite')->name('tramites_y_servicios.show');

    // DESARROLLO URBANO
    Route::get('/desarrollo_urbano', 'FrontController@urbanDev')->name('urban_dev.index');
    Route::get('/desarrollo_urbano/tramites', 'FrontController@urbanDevProcedures')->name('urban_dev.procedures');
    Route::get('/desarrollo_urbano/servicios', 'FrontController@urbanDevServices')->name('urban_dev.services');
    Route::get('/desarrollo_urbano/directorio', 'FrontController@urbanDevDirectory')->name('urban_dev.directory');
    Route::get('/desarrollo_urbano/contactos/{type}', 'FrontController@urbanDevContacts')->name('urban_dev.contacts');
    Route::get('/desarrollo_urbano/tramites/{tramite}', 'FrontController@urbanDevDetail')->name('urban_dev.show');

    // CASA DE LA MUJER
    Route::get('/casa_de_la_mujer', 'FrontController@casaMujer')->name('casa_mujer.index');

    // DIF
    Route::get('/dependencia-dif', 'FrontController@dif')->name('dif.index');


    // Contraloría
    Route::get('/contraloria', 'FrontController@contraloria')->name('contraloria.index');
    Route::get('/contraloria/declaracion-patrimonial', 'FrontController@contraloriaDeclaration')->name('contraloria.declaration');
    Route::get('/contraloria/entrega-recepcion', 'FrontController@contraloriaReception')->name('contraloria.reception');
    Route::get('/contraloria/quejas-denuncias-y-sugerencias', 'FrontController@contraloriaSuggestions')->name('contraloria.suggestions');
    Route::get('/contraloria/aviso-de-privacidad', 'FrontController@contraloriaPrivacyNotice')->name('contraloria.privacy_notice');


    Route::get('/contraloria/faltas-administrativas', 'FrontController@contraloriaFaults')->name('contraloria.faults');
    Route::get('/contraloria/faltas-administrativas/no-graves', 'FrontController@contraloriaFaultsNotSerious')->name('contraloria.faults.not-serious');
    Route::get('/contraloria/faltas-administrativas/sanciones-faltas-no-graves', 'FrontController@contraloriaFaultsNotSeriousRules')->name('contraloria.faults.not-serious-rules');
    Route::get('/contraloria/faltas-administrativas/graves', 'FrontController@contraloriaFaultsSerious')->name('contraloria.faults.serious');

    /*Denuncia NET*/
    Route::get('/denuncia-net', 'FrontController@denunciaNet')->name('denuncia.net');
    Route::get('/denuncia-net/estatus', 'FrontController@denunciaNetShow')->name('denuncia.net.show');

    /* Predial en Línea */
    Route::get('/predial-en-linea', 'FrontController@predialSearch')->name('predial.search');
    Route::post('/predial-en-linea/resultados', 'FrontController@predialSearchResults')->name('predial.search.results');

    // Módulo Gaceta Municipal
    Route::get('/gaceta-municipal/{type}', [
        'uses' => 'FrontController@gazetteList',
        'as' => 'gazette.list',
    ]);

    // Módulo Convocatorias de Transparencia
    Route::get('/convocatorias', [
        'uses' => 'FrontController@proposalsList',
        'as' => 'proposals.list',
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

    // Módulo Adquisiciones
    Route::get('/adquisiciones', [
        'uses' => 'FrontController@acquisitions',
        'as' => 'acquisitions.index',
    ]);

    /* ------------------- */
    /* ------------------- */

    // Back-End Views
    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'can:admin_access']], function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::post('/notification-manual', 'DashboardController@createNote')->name('create.manual.notification');

        /* Usuarios */
        Route::resource('users', UserController::class);

        // Rutas adicionales para usuarios ciudadanos
        Route::post('users/citizens', 'UserController@storeCitizen')->name('users.store-citizen');
        Route::put('users/citizens/{id}', 'UserController@updateCitizen')->name('users.update-citizen');
        Route::delete('users/citizens/{id}', 'UserController@destroyCitizen')->name('users.destroy-citizen');

        Route::resource('roles', RoleController::class);

        // Rutas adicionales para permisos
        Route::post('roles/permissions', 'RoleController@storePermission')->name('roles.store-permission');
        Route::put('roles/permissions/{id}', 'RoleController@updatePermission')->name('roles.update-permission');
        Route::delete('roles/permissions/{id}', 'RoleController@destroyPermission')->name('roles.destroy-permission');

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

        /* Convocatorias */
        Route::resource('trn_proposals', TrnProposalController::class);

        /* ------------------- */
        /* ------------------- */

        /* Ciudadanos */
        Route::resource('citizens', CitizenController::class);

        Route::post('/importacion-ciudadanos', [
            'uses' => 'CitizenController@import',
            'as' => 'citizens.import',
        ]);

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

        /* SARE */
        Route::group(['prefix' => 'sare'], function () {
            Route::resource('requests', SareRequestController::class)->names([
                'index' => 'sare.request.index',
                'create' => 'sare.request.create',
                'store' => 'sare.request.store',
                'show' => 'sare.request.show',
                'edit' => 'sare.request.edit',
                'update' => 'sare.request.update',
                'destroy' => 'sare.request.destroy',
            ]);

            Route::resource('request_notes', SareRequestNoteController::class)->names([
                'index' => 'sare.request_notes.index',
                'create' => 'sare.request_notes.create',
                'store' => 'sare.request_notes.store',
                'show' => 'sare.request_notes.show',
                'edit' => 'sare.request_notes.edit',
                'update' => 'sare.request_notes.update',
                'destroy' => 'sare.request_notes.destroy',
            ]);

            Route::resource('request_files', SareRequestFileController::class)->names([
                'index' => 'sare.request_files.index',
                'create' => 'sare.request_files.create',
                'store' => 'sare.request_files.store',
                'show' => 'sare.request_files.show',
                'edit' => 'sare.request_files.edit',
                'update' => 'sare.request_files.update',
                'destroy' => 'sare.request_files.destroy',
            ]);
        });

        /* Desarrollo Urbano */
        Route::group(['prefix' => 'urban_dev'], function () {
            Route::resource('requests', UrbanDevRequestController::class)->names([
                'index' => 'urban_dev.requests.index',
                'create' => 'urban_dev.requests.create',
                'store' => 'urban_dev.requests.store',
                'show' => 'urban_dev.requests.show',
                'edit' => 'urban_dev.requests.edit',
                'update' => 'urban_dev.requests.update',
                'destroy' => 'urban_dev.requests.destroy',
            ]);

            // Ruta adicional para actualizar detalles específicos
            Route::put('requests/{id}/update-details', [UrbanDevRequestController::class, 'updateDetails'])->name('urban_dev.requests.update-details');

            // Ruta para búsqueda/query
            Route::get('requests-query', [UrbanDevRequestController::class, 'query'])->name('urban_dev.requests.query');

            // Rutas para exportación
            Route::get('requests-export-excel', [UrbanDevRequestController::class, 'exportExcel'])->name('urban_dev.requests.export-excel');
            Route::get('requests-export-pdf', [UrbanDevRequestController::class, 'exportPdf'])->name('urban_dev.requests.export-pdf');

            Route::resource('request_notes', UrbanDevRequestNoteController::class)->names([
                'index' => 'urban_dev.request_notes.index',
                'create' => 'urban_dev.request_notes.create',
                'store' => 'urban_dev.request_notes.store',
                'show' => 'urban_dev.request_notes.show',
                'edit' => 'urban_dev.request_notes.edit',
                'update' => 'urban_dev.request_notes.update',
                'destroy' => 'urban_dev.request_notes.destroy',
            ]);

            Route::resource('request_files', UrbanDevRequestFileController::class)->names([
                'index' => 'urban_dev.request_files.index',
                'create' => 'urban_dev.request_files.create',
                'store' => 'urban_dev.request_files.store',
                'show' => 'urban_dev.request_files.show',
                'edit' => 'urban_dev.request_files.edit',
                'update' => 'urban_dev.request_files.update',
                'destroy' => 'urban_dev.request_files.destroy',
            ]);

            Route::resource('inspectors', UrbanDevInspectorController::class)->names([
                'index' => 'urban_dev.inspectors.index',
                'create' => 'urban_dev.inspectors.create',
                'store' => 'urban_dev.inspectors.store',
                'show' => 'urban_dev.inspectors.show',
                'edit' => 'urban_dev.inspectors.edit',
                'update' => 'urban_dev.inspectors.update',
                'destroy' => 'urban_dev.inspectors.destroy',
            ]);

            // Rutas para trabajadores de Desarrollo Urbano
            Route::get('workers/inspectors', [UrbanDevWorkerController::class, 'inspectors'])->name('urban_dev.workers.inspectors');
            Route::get('workers/experts', [UrbanDevWorkerController::class, 'experts'])->name('urban_dev.workers.experts');
            Route::get('workers/civil_defense', [UrbanDevWorkerController::class, 'civilDefense'])->name('urban_dev.workers.civil_defense');
            Route::get('workers/auditors', [UrbanDevWorkerController::class, 'auditors'])->name('urban_dev.workers.auditors');

            Route::resource('workers', UrbanDevWorkerController::class)->names([
                'create' => 'urban_dev.workers.create',
                'store' => 'urban_dev.workers.store',
                'show' => 'urban_dev.workers.show',
                'edit' => 'urban_dev.workers.edit',
                'update' => 'urban_dev.workers.update',
                'destroy' => 'urban_dev.workers.destroy',
            ]);

            Route::post('/importacion-trabajadores', [
                'uses' => 'UrbanDevWorkerController@import',
                'as' => 'urban_dev.workers.import',
            ]);

            // Ruta para solicitudes de inspector
            Route::get('inspector_requests', [UrbanDevInspectorController::class, 'requests'])->name('urban_dev.inspectors.requests');

            // Ruta para KPIs de desarrollo urbano
            Route::get('kpis', [UrbanDevKPIsController::class, 'index'])->name('urban_dev.kpis.index');
        });

        /* DIF */
        Route::group(['prefix' => 'dif'], function () {
            Route::resource('doctors', DIFDoctorController::class)->names([
                'index' => 'dif.doctors.index',
                'create' => 'dif.doctors.create',
                'store' => 'dif.doctors.store',
                'show' => 'dif.doctors.show',
                'edit' => 'dif.doctors.edit',
                'update' => 'dif.doctors.update',
                'destroy' => 'dif.doctors.destroy',
            ]);

            Route::resource('specialties', DIFSpecialtyController::class)->names([
                'index' => 'dif.specialties.index',
                'create' => 'dif.specialties.create',
                'store' => 'dif.specialties.store',
                'show' => 'dif.specialties.show',
                'edit' => 'dif.specialties.edit',
                'update' => 'dif.specialties.update',
                'destroy' => 'dif.specialties.destroy',
            ]);

            Route::resource('consult_types', DIFConsultTypeController::class)->names([
                'index' => 'dif.consult_types.index',
                'create' => 'dif.consult_types.create',
                'store' => 'dif.consult_types.store',
                'show' => 'dif.consult_types.show',
                'edit' => 'dif.consult_types.edit',
                'update' => 'dif.consult_types.update',
                'destroy' => 'dif.consult_types.destroy',
            ]);

            Route::resource('services', DIFServiceController::class)->names([
                'index' => 'dif.services.index',
                'create' => 'dif.services.create',
                'store' => 'dif.services.store',
                'show' => 'dif.services.show',
                'edit' => 'dif.services.edit',
                'update' => 'dif.services.update',
                'destroy' => 'dif.services.destroy',
            ]);

            Route::resource('locations', DIFLocationController::class)->names([
                'index' => 'dif.locations.index',
                'create' => 'dif.locations.create',
                'store' => 'dif.locations.store',
                'show' => 'dif.locations.show',
                'edit' => 'dif.locations.edit',
                'update' => 'dif.locations.update',
                'destroy' => 'dif.locations.destroy',
            ]);

            Route::resource('location_assignments', DIFLocationAssignmentController::class)->names([
                'index' => 'dif.location_assignments.index',
                'create' => 'dif.location_assignments.create',
                'store' => 'dif.location_assignments.store',
                'show' => 'dif.location_assignments.show',
                'edit' => 'dif.location_assignments.edit',
                'update' => 'dif.location_assignments.update',
                'destroy' => 'dif.location_assignments.destroy',
            ]);

            Route::resource('socio_economic_tests', DIFSocioEconomicTestController::class)->names([
                'index' => 'dif.socio_economic_tests.index',
                'create' => 'dif.socio_economic_tests.create',
                'store' => 'dif.socio_economic_tests.store',
                'show' => 'dif.socio_economic_tests.show',
                'edit' => 'dif.socio_economic_tests.edit',
                'update' => 'dif.socio_economic_tests.update',
                'destroy' => 'dif.socio_economic_tests.destroy',
            ]);

            // Rutas adicionales para los pasos del formulario de estudios socioeconómicos
            Route::group(['prefix' => 'socio_economic_tests'], function () {
                // Paso 2: Proveedor Económico
                Route::get('{id}/paso-2', 'DIFSocioEconomicTestController@step2')->name('dif.socio_economic_tests.step2');
                Route::post('{id}/paso-2', 'DIFSocioEconomicTestController@storeStep2')->name('dif.socio_economic_tests.step2.store');

                // Paso 3: Estructura Familiar
                Route::get('{id}/paso-3', 'DIFSocioEconomicTestController@step3')->name('dif.socio_economic_tests.step3');
                Route::post('{id}/paso-3', 'DIFSocioEconomicTestController@storeStep3')->name('dif.socio_economic_tests.step3.store');

                // Paso 4: Estructura Económica
                Route::get('{id}/paso-4', 'DIFSocioEconomicTestController@step4')->name('dif.socio_economic_tests.step4');
                Route::post('{id}/paso-4', 'DIFSocioEconomicTestController@storeStep4')->name('dif.socio_economic_tests.step4.store');

                // Paso 5: Salud y Vivienda
                Route::get('{id}/paso-5', 'DIFSocioEconomicTestController@step5')->name('dif.socio_economic_tests.step5');
                Route::post('{id}/paso-5', 'DIFSocioEconomicTestController@storeStep5')->name('dif.socio_economic_tests.step5.store');

                // Rutas AJAX para cálculo en tiempo real
                Route::post('calcular-puntaje', 'DIFSocioEconomicTestController@updateScore')->name('dif.socio_economic_tests.update_score');

                // Rutas para gestión de dependientes
                Route::post('{id}/dependientes', 'DIFSocioEconomicTestController@addDependent')->name('dif.socio_economic_tests.add_dependent');
                Route::put('dependientes/{dependentId}', 'DIFSocioEconomicTestController@updateDependent')->name('dif.socio_economic_tests.update_dependent');
                Route::delete('dependientes/{dependentId}', 'DIFSocioEconomicTestController@removeDependent')->name('dif.socio_economic_tests.remove_dependent');

                // Rutas para gestión de archivos
                Route::post('{id}/archivos', 'DIFSocioEconomicTestController@uploadFile')->name('dif.socio_economic_tests.upload_file');
                Route::delete('archivos/{fileId}', 'DIFSocioEconomicTestController@deleteFile')->name('dif.socio_economic_tests.delete_file');
                Route::get('archivos/{fileId}/descargar', 'DIFSocioEconomicTestController@downloadFile')->name('dif.socio_economic_tests.download_file');

                // Rutas para aprobación/rechazo
                Route::post('{id}/aprobar', 'DIFSocioEconomicTestController@approve')->name('dif.socio_economic_tests.approve');
                Route::post('{id}/rechazar', 'DIFSocioEconomicTestController@reject')->name('dif.socio_economic_tests.reject');

                // Ruta para generar PDF del estudio
                Route::get('{id}/pdf', 'DIFSocioEconomicTestController@generatePDF')->name('dif.socio_economic_tests.pdf');

                // Ruta para búsqueda de ciudadanos (AJAX)
                Route::get('buscar-ciudadanos', 'DIFSocioEconomicTestController@searchCitizens')->name('dif.socio_economic_tests.search_citizens');
            });

            Route::resource('socio_economic_test_dependents', DIFSocioEconomicTestDependentController::class)->names([
                'index' => 'dif.socio_economic_test_dependents.index',
                'create' => 'dif.socio_economic_test_dependents.create',
                'store' => 'dif.socio_economic_test_dependents.store',
                'show' => 'dif.socio_economic_test_dependents.show',
                'edit' => 'dif.socio_economic_test_dependents.edit',
                'update' => 'dif.socio_economic_test_dependents.update',
                'destroy' => 'dif.socio_economic_test_dependents.destroy',
            ]);

            Route::resource('socio_economic_test_files', DIFSocioEconomicTestFileController::class)->names([
                'index' => 'dif.socio_economic_test_files.index',
                'create' => 'dif.socio_economic_test_files.create',
                'store' => 'dif.socio_economic_test_files.store',
                'show' => 'dif.socio_economic_test_files.show',
                'edit' => 'dif.socio_economic_test_files.edit',
                'update' => 'dif.socio_economic_test_files.update',
                'destroy' => 'dif.socio_economic_test_files.destroy',
            ]);

            Route::resource('social_assistances', DIFSocialAssistanceController::class)->names([
                'index' => 'dif.social_assistances.index',
                'create' => 'dif.social_assistances.create',
                'store' => 'dif.social_assistances.store',
                'show' => 'dif.social_assistances.show',
                'edit' => 'dif.social_assistances.edit',
                'update' => 'dif.social_assistances.update',
                'destroy' => 'dif.social_assistances.destroy',
            ]);

            Route::resource('medications', DIFMedicationController::class)->names([
                'index' => 'dif.medications.index',
                'create' => 'dif.medications.create',
                'store' => 'dif.medications.store',
                'show' => 'dif.medications.show',
                'edit' => 'dif.medications.edit',
                'update' => 'dif.medications.update',
                'destroy' => 'dif.medications.destroy',
            ]);

            Route::resource('medication_variants', DIFMedicationVariantController::class)->names([
                'index' => 'dif.medication_variants.index',
                'create' => 'dif.medication_variants.create',
                'store' => 'dif.medication_variants.store',
                'show' => 'dif.medication_variants.show',
                'edit' => 'dif.medication_variants.edit',
                'update' => 'dif.medication_variants.update',
                'destroy' => 'dif.medication_variants.destroy',
            ]);

            Route::resource('stock_movements', DIFStockMovementController::class)->names([
                'index' => 'dif.stock_movements.index',
                'create' => 'dif.stock_movements.create',
                'store' => 'dif.stock_movements.store',
                'show' => 'dif.stock_movements.show',
                'edit' => 'dif.stock_movements.edit',
                'update' => 'dif.stock_movements.update',
                'destroy' => 'dif.stock_movements.destroy',
            ]);

            // Endpoint AJAX para obtener lotes disponibles por variante
            Route::get('stock_movements_batches', [DIFStockMovementController::class, 'batches'])->name('dif.stock_movements.batches');

            // Ruta adicional para generar recibo PDF
            Route::get('stock_movements/{movement}/receipt', [DIFStockMovementController::class, 'receipt'])->name('dif.stock_movements.receipt');

            // Rutas adicionales para ver movimientos por tipo
            Route::get('stock_movements_inbound', [DIFStockMovementController::class, 'inbound'])->name('dif.stock_movements.inbound');
            Route::get('stock_movements_outbound', [DIFStockMovementController::class, 'outbound'])->name('dif.stock_movements.outbound');

            Route::resource('legal_processes', DIFLegalProcessController::class)->names([
                'index' => 'dif.legal_processes.index',
                'create' => 'dif.legal_processes.create',
                'store' => 'dif.legal_processes.store',
                'show' => 'dif.legal_processes.show',
                'edit' => 'dif.legal_processes.edit',
                'update' => 'dif.legal_processes.update',
                'destroy' => 'dif.legal_processes.destroy',
            ]);

            // Ruta para búsqueda de conceptos de pago via Ajax (debe ir antes del resource)
            Route::get('payment-concepts/search', 'DIFPaymentConceptController@search')->name('dif.payment-concepts.search');

            Route::resource('payment_concepts', DIFPaymentConceptController::class)->names([
                'index' => 'dif.payment_concepts.index',
                'create' => 'dif.payment_concepts.create',
                'store' => 'dif.payment_concepts.store',
                'show' => 'dif.payment_concepts.show',
                'edit' => 'dif.payment_concepts.edit',
                'update' => 'dif.payment_concepts.update',
                'destroy' => 'dif.payment_concepts.destroy',
            ]);

            Route::resource('coordinations', DIFCoordinationController::class)->names([
                'index' => 'dif.coordinations.index',
                'create' => 'dif.coordinations.create',
                'store' => 'dif.coordinations.store',
                'show' => 'dif.coordinations.show',
                'edit' => 'dif.coordinations.edit',
                'update' => 'dif.coordinations.update',
                'destroy' => 'dif.coordinations.destroy',
            ]);

            // Ruta para búsqueda de programas via Ajax (debe ir antes del resource)
            Route::get('programs/search', [DIFProgramController::class, 'search'])->name('dif.programs.search');

            Route::resource('programs', DIFProgramController::class)->names([
                'index' => 'dif.programs.index',
                'create' => 'dif.programs.create',
                'store' => 'dif.programs.store',
                'show' => 'dif.programs.show',
                'edit' => 'dif.programs.edit',
                'update' => 'dif.programs.update',
                'destroy' => 'dif.programs.destroy',
            ]);

            Route::resource('receipts', DIFReceiptController::class)->names([
                'index' => 'dif.receipts.index',
                'create' => 'dif.receipts.create',
                'store' => 'dif.receipts.store',
                'show' => 'dif.receipts.show',
                'edit' => 'dif.receipts.edit',
                'update' => 'dif.receipts.update',
                'destroy' => 'dif.receipts.destroy',
            ]);

            // Ruta AJAX para calcular totales
            Route::post('receipts/calculate-totals', 'DIFReceiptController@calculateTotals')
                ->name('dif.receipts.calculate-totals');

            // Ruta para descargar recibo en PDF
            Route::get('receipts/{id}/download', 'DIFReceiptController@downloadReceipt')
                ->name('dif.receipts.download');

            // Rutas para búsqueda de pacientes via Ajax (debe ir antes del resource)
            Route::get('patients/search', 'SearchController@citizenQuery')->name('dif.patients.search');
            Route::get('patients/{id}', 'CitizenController@show')->name('dif.patients.show');

            // Este modulo es el perfil de los pacientes que esta vinculado a un ciudadano (citizen).
            // Para diferenciarlo del modulo de ciudadanos, se usa el prefijo 'medical-profile'

            // Ruta para obtener información del ciudadano via Ajax (debe ir antes del resource)
            Route::get('medical-profiles/citizen/{id}', [CitizenMedicalProfileController::class, 'getCitizenInfo'])->name('dif.medical_profiles.citizen_info');

            Route::resource('medical-profiles', CitizenMedicalProfileController::class)->names([
                'index' => 'dif.medical_profiles.index',
                'create' => 'dif.medical_profiles.create',
                'store' => 'dif.medical_profiles.store',
                'show' => 'dif.medical_profiles.show',
                'edit' => 'dif.medical_profiles.edit',
                'update' => 'dif.medical_profiles.update',
                'destroy' => 'dif.medical_profiles.destroy',
            ]);

            Route::resource('consults', DIFDoctorConsultController::class)->names([
                'index' => 'dif.consults.index',
                'create' => 'dif.consults.create',
                'store' => 'dif.consults.store',
                'show' => 'dif.consults.show',
                'edit' => 'dif.consults.edit',
                'update' => 'dif.consults.update',
                'destroy' => 'dif.consults.destroy',
            ]);

            Route::resource('prescriptions', DIFPrescriptionController::class)->names([
                'index' => 'dif.prescriptions.index',
                'create' => 'dif.prescriptions.create',
                'store' => 'dif.prescriptions.store',
                'show' => 'dif.prescriptions.show',
                'edit' => 'dif.prescriptions.edit',
                'update' => 'dif.prescriptions.update',
                'destroy' => 'dif.prescriptions.destroy',
            ]);

            // Rutas para archivos de prescripciones
            Route::resource('prescription-files', DIFPrescriptionFileController::class)->names([
                'index' => 'dif.prescription-files.index',
                'create' => 'dif.prescription-files.create',
                'store' => 'dif.prescription-files.store',
                'show' => 'dif.prescription-files.show',
                'edit' => 'dif.prescription-files.edit',
                'update' => 'dif.prescription-files.update',
                'destroy' => 'dif.prescription-files.destroy',
            ]);
            Route::get('prescription-files/{prescriptionFile}/download', [DIFPrescriptionFileController::class, 'download'])->name('dif.prescription-files.download');

            Route::resource('banners', DIFBannerController::class)->names([
                'index' => 'dif.banners.index',
                'create' => 'dif.banners.create',
                'store' => 'dif.banners.store',
                'show' => 'dif.banners.show',
                'edit' => 'dif.banners.edit',
                'update' => 'dif.banners.update',
                'destroy' => 'dif.banners.destroy',
            ]);

            Route::post('/banners/status/{id}', [
                'uses' => 'DIFBannerController@status',
                'as' => 'dif.banners.status',
            ]);


            //Ingresos y Salidas
            Route::resource('incomes', DIFIncomeController::class)->names([
                'index' => 'dif.incomes.index',
                'create' => 'dif.incomes.create',
                'show' => 'dif.incomes.show',
                'edit' => 'dif.incomes.edit',
                'destroy' => 'dif.incomes.destroy',
            ]);

            Route::resource('expenses', DIFExpenseController::class)->names([
                'index' => 'dif.expenses.index',
                'create' => 'dif.expenses.create',
                'show' => 'dif.expenses.show',
                'edit' => 'dif.expenses.edit',
                'destroy' => 'dif.expenses.destroy',
            ]);
        });

        /* Adquisiciones */
        Route::group(['prefix' => 'acquisitions'], function () {
            // Solicitudes de Alta de Proveedor
            Route::resource('suppliers', AcquisitionSupplierController::class)->names([
                'index' => 'acquisitions.suppliers.index',
                'create' => 'acquisitions.suppliers.create',
                'store' => 'acquisitions.suppliers.store',
                'show' => 'acquisitions.suppliers.show',
                'edit' => 'acquisitions.suppliers.edit',
                'update' => 'acquisitions.suppliers.update',
                'destroy' => 'acquisitions.suppliers.destroy',
            ]);

            Route::resource('supplier_messages', SupplierMessageController::class)->names([
                'index' => 'acquisitions.supplier_messages.index',
                'create' => 'acquisitions.supplier_messages.create',
                'store' => 'acquisitions.supplier_messages.store',
                'show' => 'acquisitions.supplier_messages.show',
                'edit' => 'acquisitions.supplier_messages.edit',
                'update' => 'acquisitions.supplier_messages.update',
                'destroy' => 'acquisitions.supplier_messages.destroy',
            ]);

            // Acciones adicionales para proveedores
            Route::post('suppliers/{id}/file/{fileId}/status', [AcquisitionSupplierController::class, 'updateFileStatus'])
                ->name('acquisitions.suppliers.updateFileStatus');
            Route::post('suppliers/{id}/approvals', [AcquisitionSupplierController::class, 'saveApprovals'])
                ->name('acquisitions.suppliers.saveApprovals');
            Route::post('suppliers/{id}/status', [AcquisitionSupplierController::class, 'updateStatus'])
                ->name('acquisitions.suppliers.updateStatus');
            Route::post('suppliers/{id}/contact', [AcquisitionSupplierController::class, 'contact'])
                ->name('acquisitions.suppliers.contact');

            // Proveedores Sin/Con Padrón
            Route::get('sin_padron', [AcquisitionSupplierController::class, 'sinPadron'])->name('acquisitions.suppliers.sin_padron');
            Route::get('con_padron', [AcquisitionSupplierController::class, 'conPadron'])->name('acquisitions.suppliers.con_padron');

            // Refrendos
            Route::get('endorsements', [AcquisitionEndorsementController::class, 'index'])
                ->name('acquisitions.endorsements.index');
            Route::get('endorsements/{userId}', [AcquisitionEndorsementController::class, 'show'])
                ->name('acquisitions.endorsements.show');
            Route::post('endorsements/{endorsementId}/status', [AcquisitionEndorsementController::class, 'updateStatus'])
                ->name('acquisitions.endorsements.updateStatus');
            Route::post('endorsements/{endorsementId}/associate', [AcquisitionEndorsementController::class, 'associateSupplier'])
                ->name('acquisitions.endorsements.associate');


            //Licitaciones
            Route::resource('biddings', BiddingController::class)->names([
                'index' => 'acquisitions.biddings.index',
                'create' => 'acquisitions.biddings.create',
                'show' => 'acquisitions.biddings.show',
                'edit' => 'acquisitions.biddings.edit',
                'destroy' => 'acquisitions.biddings.destroy',
            ]);

            //Contratos
            Route::get('contracts', [BiddingContractController::class, 'index'])->name('acquisitions.bidding.contract');
            Route::get('close_contracts', [BiddingContractController::class, 'closed'])->name('acquisitions.bidding.contract_closed');


            Route::resource('materials', AcquisitionMaterialController::class)->names([
                'index' => 'acquisitions.materials.index',
                'create' => 'acquisitions.materials.create',
                'show' => 'acquisitions.materials.show',
                'edit' => 'acquisitions.materials.edit',
                'destroy' => 'acquisitions.materials.destroy',
            ]);

            Route::get('inventory', [AcquisitionsInventoryController::class, 'index'])->name('acquisitions.inventory.index');
            Route::get('inventory_entrance', [AcquisitionsInventoryController::class, 'entrance'])->name('acquisitions.inventory.entrance');
            Route::get('inventory_exit', [AcquisitionsInventoryController::class, 'exit'])->name('acquisitions.inventory.exit');
            Route::get('inventory/movement/{id?}', [AcquisitionsInventoryController::class, 'create'])->name('acquisitions.inventory.create');
            Route::get('invetory/show/{id}', [AcquisitionsInventoryController::class, 'show'])->name('acquisitions.inventory.show');

            Route::resource('movements', AcquisitionInventoryMovementController::class)->names([
                'index' => 'acquisitions.movements.index',
                'create' => 'acquisitions.movements.create',
                'show' => 'acquisitions.movements.show',
                'edit' => 'acquisitions.movements.edit',
                'destroy' => 'acquisitions.movements.destroy',
            ]);

            // Ruta para KPIs de Adquisiciones
            Route::get('kpis', [AcquisitionsKPIsController::class, 'index'])->name('acquisitions.kpis.index');
        });

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

            // Rutas para subida por chunks de archivos de transparencia
            Route::post('/files/init-chunk-upload', [
                'uses' => 'TransparencyFileController@initChunkUpload',
                'as' => 'transparency_files.init-chunk-upload',
            ]);

            Route::post('/files/upload-chunk', [
                'uses' => 'TransparencyFileController@uploadChunk',
                'as' => 'transparency_files.upload-chunk',
            ]);

            Route::post('/files/finalize-chunk-upload', [
                'uses' => 'TransparencyFileController@finalizeChunkUpload',
                'as' => 'transparency_files.finalize-chunk-upload',
            ]);

            // Rutas para subida por chunks de archivos de transparencia
            Route::post('/files/init-chunk-upload', [
                'uses' => 'TransparencyFileController@initChunkUpload',
                'as' => 'transparency_files.init-chunk-upload',
            ]);

            Route::post('/files/upload-chunk', [
                'uses' => 'TransparencyFileController@uploadChunk',
                'as' => 'transparency_files.upload-chunk',
            ]);

            Route::post('/files/finalize-chunk-upload', [
                'uses' => 'TransparencyFileController@finalizeChunkUpload',
                'as' => 'transparency_files.finalize-chunk-upload',
            ]);
        });

        /* ------------------- */
        /* ------------------- */

        /* Tesorería */
        Route::group(['prefix' => 'treasury'], function () {

            /* Predial / Catastro */
            Route::resource('properties', CTOPropertyController::class); // Listado de Predios
            Route::post('properties/import', [CTOPropertyController::class, 'import'])->name('properties.import'); // Importar Excel de Predios
            Route::resource('property_taxes', CTOPropertyTaxController::class); // Recibos de los Predios
            
            // Rutas adicionales para recibos de predial
            Route::patch('property_taxes/{id}/mark-paid', [CTOPropertyTaxController::class, 'markAsPaid'])->name('property_taxes.mark-paid');
            Route::get('property_taxes/{id}/print', [CTOPropertyTaxController::class, 'print'])->name('property_taxes.print');

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

            Route::resource('account_payable', TreasuryAccountPayableController::class)->names([
                'index' => 'account_payable.index',
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
                'edit' => 'supplier_checklist_authorizations.edit',
                'show' => 'supplier_checklist_authorizations.show',
                'destroy' => 'supplier_checklist_authorizations.destroy',
            ]);

            Route::resource('checklist_authorizations_notes', TapChecklistAuthorizationNoteController::class)->names([
                'store' => 'supplier_checklist_authorizations_notes.store',
            ]);

            Route::resource('suppliers_logs', TapSupplierLogController::class)->names([
                'update' => 'suppliers_logs.update',
                'destroy' => 'suppliers_logs.destroy',
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


        Route::group(['prefix' => 'institucional_development'], function () {
            Route::resource('regulations', MunicipalRegulationController::class)->names([
                'index' => 'institucional_development.regulations.index',
                'show' => 'institucional_development.regulations.show',
                'edit' => 'institucional_development.regulations.edit',
                'create' => 'institucional_development.regulations.create',
                'destroy' => 'institucional_development.regulations.destroy',
            ]);

            Route::resource('banners', InstitucionalDevelopmentBannerController::class)->names([
                'index' => 'institucional_development.banners.index',
                'create' => 'institucional_development.banners.create',
                'store' => 'institucional_development.banners.store',
                'show' => 'institucional_development.banners.show',
                'edit' => 'institucional_development.banners.edit',
                'update' => 'institucional_development.banners.update',
                'destroy' => 'institucional_development.banners.destroy',
            ]);

            Route::post('/banners/status/{id}', [
                'uses' => 'InstitucionalDevelopmentBannerController@status',
                'as' => 'institucional_development.banners.status',
            ]);

            Route::resource('requests', ServiceRequestController::class)->names([
                'index' => 'institucional_development.requests.index',
                'show' => 'institucional_development.requests.show',
                'edit' => 'institucional_development.requests.edit',
                'create' => 'institucional_development.requests.create',
                'destroy' => 'institucional_development.requests.destroy',
            ]);
        });

        //Inspecciones municipales
        Route::resource('municipal_inspections', MunicipalInspectionController::class)->names([
            'index' => 'municipal_inspections.index',
            'create' => 'municipal_inspections.create',
            'store' => 'municipal_inspections.store',
            'show' => 'municipal_inspections.show',
            'edit' => 'municipal_inspections.edit',
            'update' => 'municipal_inspections.update',
            'destroy' => 'municipal_inspections.destroy',
        ]);

        //Actas de Consejo
        Route::resource('council_minutes', CouncilMinuteController::class)->names([
            'index' => 'council_minutes.index',
            'create' => 'council_minutes.create',
            'store' => 'council_minutes.store',
            'show' => 'council_minutes.show',
            'edit' => 'council_minutes.edit',
            'update' => 'council_minutes.update',
            'destroy' => 'council_minutes.destroy',
        ]);

        //Citatorios
        Route::resource('summons', SummonController::class)->names([
            'index' => 'summons.index',
            'create' => 'summons.create',
            'store' => 'summons.store',
            'show' => 'summons.show',
            'edit' => 'summons.edit',
            'update' => 'summons.update',
            'destroy' => 'summons.destroy',
        ]);

        /* ------------------- */
        /* ------------------- */
        /* IMPLAN */
        Route::group(['prefix' => 'implan'], function () {
            Route::resource('projects', ImplanProjectController::class)->names([
                'index' => 'implan.projects.index',
                'create' => 'implan.projects.create',
                'store' => 'implan.projects.store',
                'show' => 'implan.projects.show',
                'edit' => 'implan.projects.edit',
                'update' => 'implan.projects.update',
                'destroy' => 'implan.projects.destroy',
            ]);

            Route::resource('blog', ImplanBlogController::class)->names([
                'index' => 'implan.blog.index',
                'create' => 'implan.blog.create',
                'store' => 'implan.blog.store',
                'show' => 'implan.blog.show',
                'edit' => 'implan.blog.edit',
                'update' => 'implan.blog.update',
                'destroy' => 'implan.blog.destroy',
            ]);

            Route::resource('achievements', ImplanAchievementController::class)->names([
                'index' => 'implan.achievements.index',
                'create' => 'implan.achievements.create',
                'store' => 'implan.achievements.store',
                'show' => 'implan.achievements.show',
                'edit' => 'implan.achievements.edit',
                'update' => 'implan.achievements.update',
                'destroy' => 'implan.achievements.destroy',
            ]);

            Route::resource('banners', ImplanBannerController::class)->names([
                'index' => 'implan.banners.index',
                'create' => 'implan.banners.create',
                'store' => 'implan.banners.store',
                'show' => 'implan.banners.show',
                'edit' => 'implan.banners.edit',
                'update' => 'implan.banners.update',
                'destroy' => 'implan.banners.destroy',
            ]);

            Route::post('/implan/banners/status/{id}', [
                'uses' => 'ImplanBannerController@status',
                'as' => 'implan.banners.status',
            ]);
        });
    });

    // Rutas del Perfil Ciudadano (Front-End)
    Route::group(['prefix' => 'ciudadanos', 'middleware' => ['auth', 'role:citizen'], 'namespace' => 'Front'], function () {
        Route::get('/perfil', 'CitizenProfileController@index')->name('citizen.profile.index');
        Route::get('/perfil/editar', 'CitizenProfileController@edit')->name('citizen.profile.edit');
        Route::put('/perfil/actualizar', 'CitizenProfileController@update')->name('citizen.profile.update');
        Route::get('/perfil/solicitudes', 'CitizenProfileController@requests')->name('citizen.profile.requests');
        Route::get('/perfil/tramites', 'CitizenProfileController@urbanDevRequests')->name('citizen.profile.urban_dev_requests');
        Route::get('/perfil/configuraciones', 'CitizenProfileController@settings')->name('citizen.profile.settings');
        Route::put('/perfil/notificaciones', 'CitizenProfileController@updateNotifications')->name('citizen.profile.notifications');

        // Rutas SARE para ciudadanos
        Route::get('/sare/crear', 'CitizenProfileController@createSareRequest')->name('citizen.sare.create');
        Route::post('/sare/guardar', 'CitizenProfileController@storeSareRequest')->name('citizen.sare.store');
        Route::get('/sare/{sareRequest}', 'CitizenProfileController@showSareRequest')->name('citizen.sare.show');
        Route::get('/sare/{sareRequest}/editar', 'CitizenProfileController@editSareRequest')->name('citizen.sare.edit');
        Route::put('/sare/{sareRequest}/actualizar', 'CitizenProfileController@updateSareRequest')->name('citizen.sare.update');
        Route::delete('/sare/{sareRequest}/eliminar', 'CitizenProfileController@destroySareRequest')->name('citizen.sare.destroy');

        // Rutas para archivos de SARE
        Route::post('/sare/archivo/subir', 'CitizenProfileController@uploadSareFile')->name('citizen.sare.file.upload');
        Route::delete('/sare/archivo/{fileId}/eliminar', 'CitizenProfileController@deleteSareFile')->name('citizen.sare.file.delete');

        // Rutas Desarrollo Urbano para ciudadanos
        Route::get('/desarrollo-urbano/crear', 'CitizenProfileController@createUrbanDevRequest')->name('citizen.urban_dev.create');
        Route::post('/desarrollo-urbano/guardar', 'CitizenProfileController@storeUrbanDevRequest')->name('citizen.urban_dev.store');
        Route::get('/desarrollo-urbano/{urbanDevRequest}', 'CitizenProfileController@showUrbanDevRequest')->name('citizen.urban_dev.show');
        Route::get('/desarrollo-urbano/{urbanDevRequest}/editar', 'CitizenProfileController@editUrbanDevRequest')->name('citizen.urban_dev.edit');
        Route::put('/desarrollo-urbano/{urbanDevRequest}/actualizar', 'CitizenProfileController@updateUrbanDevRequest')->name('citizen.urban_dev.update');
        Route::delete('/desarrollo-urbano/{urbanDevRequest}/eliminar', 'CitizenProfileController@destroyUrbanDevRequest')->name('citizen.urban_dev.destroy');

        // Rutas para archivos de desarrollo urbano
        Route::post('/desarrollo-urbano/archivo/subir', 'CitizenProfileController@uploadUrbanDevFile')->name('citizen.urban_dev.file.upload');
        Route::delete('/desarrollo-urbano/archivo/{fileId}/eliminar', 'CitizenProfileController@deleteUrbanDevFile')->name('citizen.urban_dev.file.delete');

        //Rutas para citatorios
        Route::get('/citatorios', 'CitizenProfileController@summons')->name('citizen.summons.index');
        Route::get('/citatorios/{id}', 'CitizenProfileController@showSummon')->name('citizen.summons.show');
    });

    // Rutas del Perfil Proveedores (Front-End)
    Route::group(['prefix' => 'proveedores', 'middleware' => ['auth', 'role:supplier'], 'namespace' => 'Front'], function () {
        Route::get('/perfil', 'SupplierProfileController@index')->name('supplier.profile.index');
        Route::get('/perfil/editar', 'SupplierProfileController@edit')->name('supplier.profile.edit');
        Route::get('/perfil/alta-proveedor', 'SupplierProfileController@create')->name('supplier.profile.create');
        Route::put('/perfil/actualizar', 'SupplierProfileController@update')->name('supplier.profile.update');
        Route::get('/perfil/configuraciones', 'SupplierProfileController@settings')->name('supplier.profile.settings');
        Route::get('/perfil/notificaciones', 'SupplierProfileController@notifications')->name('supplier.profile.notifications');
    });

    // Rutas para mensajes
    Route::post('/mensajes/{id}/marcar-leido', 'SupplierMessageController@markAsRead')->name('supplier.messages.mark_read');
    Route::post('/mensajes/{id}/archivar', 'SupplierMessageController@archive')->name('supplier.messages.archive');
    Route::post('/mensajes/{id}/desarchivar', 'SupplierMessageController@unarchive')->name('supplier.messages.unarchive');

    // Rutas para Alta de Proveedores
    Route::group(['prefix' => 'proveedores', 'middleware' => ['auth', 'role:supplier']], function () {
        // Altas de Proveedores
        Route::get('/altas', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.alta.index');
        Route::post('/altas/iniciar', [App\Http\Controllers\SupplierController::class, 'initiate'])->name('supplier.alta.initiate');
        Route::get('/altas/{id}/formulario', [App\Http\Controllers\SupplierController::class, 'showForm'])->name('supplier.alta.form');
        Route::put('/altas/{id}', [App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.alta.store');
        Route::get('/altas/{id}', [App\Http\Controllers\SupplierController::class, 'show'])->name('supplier.alta.show');
        Route::post('/altas/{id}/archivo', [App\Http\Controllers\SupplierController::class, 'uploadFile'])->name('supplier.alta.uploadFile');
        Route::delete('/altas/{id}/archivo/{fileId}', [App\Http\Controllers\SupplierController::class, 'deleteFile'])->name('supplier.alta.deleteFile');
        Route::delete('/altas/{id}', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('supplier.alta.destroy');

        // Licitaciones
        Route::get('/licitaciones', [SupplierBiddingController::class, 'index'])->name('supplier.bidding.index');
        Route::get('/licitaciones/{id}', [SupplierBiddingController::class, 'show'])->name('supplier.bidding.show');

        // Refrendos
        Route::get('/refrendos', [App\Http\Controllers\SupplierEndorsementController::class, 'index'])->name('supplier.endorsement.index');
        Route::post('/refrendos', [App\Http\Controllers\SupplierEndorsementController::class, 'store'])->name('supplier.endorsement.store');
        Route::delete('/refrendos/{id}', [App\Http\Controllers\SupplierEndorsementController::class, 'destroy'])->name('supplier.endorsement.destroy');
    });

    Route::get('/reload-captcha', [
        'uses' => 'FrontController@reloadCaptcha',
        'as' => 'reload.captcha',
    ]);
});
