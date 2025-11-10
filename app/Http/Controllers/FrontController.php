<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;

// Modelos Comunicación Social
use App\Models\Popup;
use App\Models\Banner;
use App\Models\Headerband;
use App\Models\DIFBanner;

// Modelos Gaceta Municipal
use App\Models\Gazette;

// Modelos Transparencia
use App\Models\TransparencyDependency;
use App\Models\TransparencyObligation;
use App\Models\TransparencyDocument;

// Modelos Textos Legales
use App\Models\LegalText;

// Modelos Agenda Regulatoria
use App\Models\RegulatoryAgendaDependency;
use App\Models\RegulatoryAgendaRegulation;
use Illuminate\Http\Request;

//Modelos Mejora Regulatoria
use App\Models\InstitucionalDevelopmentBanner;


// Modelos Blog
use App\Models\Blog;

// Modelos Denuncia Ciudadana
use App\Models\CitizenComplaint;
use App\Models\CitizenComplaintFile;

// Modelo Eventos
use App\Models\Event;
use App\Models\MunicipalRegulation;
use App\Models\ServiceRequest;

//IMPLAN
use App\Models\ImplanBanner;
use App\Models\ImplanProject;
use App\Models\ImplanAchievement;
use App\Models\ImplanBlog;

class FrontController extends Controller
{
    public function index()
    {
        // Modulo Gacetas Municipales
        Carbon::setLocale('es');
        $gazettes = Gazette::with('files')->orderBy('id', 'desc')->limit(5)->get();
        $dates = Gazette::selectRaw('DATE_FORMAT(meeting_date, "%Y-%m") as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->pluck('date')
            ->map(function ($date) {
                return Carbon::createFromFormat('Y-m', $date);
            });

        $ordinary_gazette_sessions = Gazette::where('type', 'ordinary')->count();
        $solemn_gazette_sessions = Gazette::where('type', 'solemn')->count();
        $extraordinary_gazette_sessions = Gazette::where('type', 'extraordinary')->count();

        // Modulo Transparencia
        // Cargar las dependencias que quieren mostrar en la página de inicio de Transparencia
        $dependencies = TransparencyDependency::where('in_index', true)->where('slug', '!=', 'unidad-de-transparencia-y-acceso-a-la-informacion')->get();

        $banners = Banner::where('is_active', true)->orderBy('priority', 'asc')->get();
        $popup = Popup::where('is_active', true)->orderBy('updated_at', 'desc')->first();
        $headerbands = Headerband::where('is_active', true)->orderBy('priority', 'asc')->get();

        //Cargar Dependencias regulatorias
        $regulation_dependencies = RegulatoryAgendaDependency::all();

        $events = Event::where('is_active', true)->orderBy('date_start', 'asc')->paginate(90);

        return view('front.index')->with([
            'gazettes' => $gazettes,
            'ordinary_gazette_sessions' => $ordinary_gazette_sessions,
            'solemn_gazette_sessions' => $solemn_gazette_sessions,
            'extraordinary_gazette_sessions' => $extraordinary_gazette_sessions,
            'dates' => $dates,
            'dependencies' => $dependencies,
            'banners' => $banners,
            'popup' => $popup,
            'headerbands' => $headerbands,
            'regulation_dependencies' => $regulation_dependencies,
            'events' => $events
        ]);
    }

    // Modulo Gacetas Municipales
    public function gazetteList($type)
    {
        switch ($type) {
            case 'all':
                $gazettes = Gazette::orderBy('id', 'desc')->paginate(10);
                break;

            case 'ordinary':
                $gazettes = Gazette::orderBy('id', 'desc')->where('type', 'ordinary')->paginate(10);
                break;

            case 'solemn':
                $gazettes = Gazette::orderBy('id', 'desc')->where('type', 'solemn')->paginate(10);
                break;

            case 'extraordinary':
                $gazettes = Gazette::orderBy('id', 'desc')->where('type', 'extraordinary')->paginate(10);
                break;
            default:
                # code...
                break;
        }

        Carbon::setLocale('es');

        $dates = Gazette::selectRaw('DATE_FORMAT(meeting_date, "%Y-%m") as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->pluck('date')
            ->map(function ($date) {
                return Carbon::createFromFormat('Y-m', $date);
            });

        return view('front.gazette.index')
            ->with('gazettes', $gazettes)
            ->with('type', $type)
            ->with('dates', $dates);
    }

    public function gazetteDetail($type, $slug)
    {
        $gazette = Gazette::where('slug', '=', $slug)->first();

        return view('front.gazette.detail')
            ->with('gazette', $gazette);
    }

    public function filterGazetteByDate($type, $date)
    {
        Carbon::setLocale('es');

        if ($type == 'all') {
            $gazettes = Gazette::whereYear('meeting_date', '=', Carbon::createFromFormat('Y-m', $date)->year)
                ->whereMonth('meeting_date', '=', Carbon::createFromFormat('Y-m', $date)->month)
                ->with('files')
                ->orderBy('meeting_date', 'desc')
                ->get();
        } else {
            $gazettes = Gazette::where('type', $type)->whereYear('meeting_date', '=', Carbon::createFromFormat('Y-m', $date)->year)
                ->whereMonth('meeting_date', '=', Carbon::createFromFormat('Y-m', $date)->month)
                ->with('files')
                ->orderBy('meeting_date', 'desc')
                ->get();
        }


        $dates = Gazette::selectRaw('DATE_FORMAT(meeting_date, "%Y-%m") as date')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get()
            ->pluck('date')
            ->map(function ($date) {
                return Carbon::createFromFormat('Y-m', $date);
            });

        return view('front.gazette.index')->with([
            'gazettes' => $gazettes,
            'type' => $type,
            'dates' => $dates
        ]);
    }

    // Módulo Transparencia
    // Módulo Dependencias
    public function transparencyIndex()
    {
        $dependencies = TransparencyDependency::where('belongs_to_treasury', false)->orderBy('name', 'asc')->get();

        return view('front.transparency')->with('dependencies', $dependencies);
    }

    public function transparencyObligations($type)
    {
        $dependency = TransparencyDependency::where('slug', 'unidad-de-transparencia-y-acceso-a-la-informacion')->first();
        $obligations = TransparencyObligation::where('dependency_id', $dependency->id)->where('type', $type)->get();

        $submenu_name = 'Transparencia';
        $submenu_description = 'Información adicional de transparencia';

        switch ($type) {
            case 'Común':
                $submenu_name = 'Obligaciones Comunes';
                $submenu_description = 'Información adicional de transparencia';
                break;

            case 'Especifica':
                $submenu_name = 'Obligaciones Específicas';
                $submenu_description = 'Información adicional de transparencia';
                break;

            case 'Aplicabilidad':
                $submenu_name = 'Tabla de Aplicabilidad';
                $submenu_description = 'Información adicional de transparencia';
                break;

            case 'Clasificados':
                $submenu_name = 'Índice de Expedientes Clasificados';
                $submenu_description = 'Información adicional de transparencia';
                break;

            case 'Graficas':
                $submenu_name = 'Gráficas Informativas';
                $submenu_description = 'Información adicional de transparencia';
                break;

            case 'Proactiva':
                $submenu_name = 'Transparencia Proactiva';
                $submenu_description = 'Información adicional de transparencia';
                break;

            default:
                # code...
                break;
        }

        return view('front.dependencies.transparency_obligations')
            ->with('dependency', $dependency)
            ->with('obligations', $obligations)
            ->with('type', $type)
            ->with('submenu_name', $submenu_name)
            ->with('submenu_description', $submenu_description);
    }

    public function dependencyList()
    {
        $dependencies = TransparencyDependency::where('belongs_to_treasury', false)->where('slug', '!=', 'unidad-de-transparencia-y-acceso-a-la-informacion')->orderBy('name', 'asc')->get();
        $treasury_dependencies = TransparencyDependency::where('belongs_to_treasury', true)->orderBy('name', 'asc')->get();

        return view('front.dependencies.index')
            ->with('dependencies', $dependencies)
            ->with('treasury_dependencies', $treasury_dependencies);
    }

    public function dependencyDetail($slug)
    {
        $dependency = TransparencyDependency::where('slug', '=', $slug)->first();

        $type = '';

        return view('front.dependencies.detail')
            ->with('dependency', $dependency)
            ->with('type', $type);
    }

    // Módulo Obligaciones
    public function obligationDetail($dependency, $slug)
    {
        Carbon::setLocale('es');

        $obligation = TransparencyObligation::where('dependency_id', $dependency)->where('slug', '=', $slug)->first();
        $documents = TransparencyDocument::where('obligation_id', $obligation->id)
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $dates = $documents->pluck('year')->unique()->map(function ($year) {
            return Carbon::createFromDate($year, 1, 15)->format('Y');
        });

        return view('front.dependencies.obligation_detail')
            ->with('dependency', TransparencyDependency::find($dependency))
            ->with('obligation', $obligation)
            ->with('documents', $documents)
            ->with('dates', $dates);
    }

    // Módulo Documentos
    public function filterTransparencyDocumentByDate($dependency, $slug, $date)
    {
        Carbon::setLocale('es');

        $obligation = TransparencyObligation::where('dependency_id', $dependency)->where('slug', '=', $slug)->first();
        $documents = TransparencyDocument::where('obligation_id', $obligation->id)
            ->where('year', '=', $date)
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $all_documents = TransparencyDocument::where('obligation_id', $obligation->id)
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $dates = $all_documents->pluck('year')->unique()->map(function ($year) {
            return Carbon::createFromDate($year, 1, 15)->format('Y');
        });

        return view('front.dependencies.obligation_detail')->with([
            'dependency' => TransparencyDependency::find($dependency),
            'obligation' => $obligation,
            'documents' => $documents,
            'dates' => $dates
        ]);
    }

    // Módulo Agenda Regulatoria
    public function regulatoryAgenda()
    {
        $dependencies = RegulatoryAgendaDependency::where('in_index', true)->orderBy('name', 'asc')->get();

        return view('front.regulatory_agenda.index')->with('dependencies', $dependencies);
    }

    public function regulatoryAgendaDependency($id)
    {
        $dependency = RegulatoryAgendaDependency::find($id);

        return view('front.regulatory_agenda.show')->with('dependency', $dependency);
    }

    // Módulo Tesorería
    public function treasuryDependencyList()
    {
        $dependencies = TransparencyDependency::where('belongs_to_treasury', true)->orderBy('name', 'asc')->get();

        return view('front.treasury.index')
            ->with('dependencies', $dependencies);
    }

    // Módulo Textos Legales
    public function legalText($slug)
    {
        $text = LegalText::where('slug', $slug)->orderBy('priority', 'asc')->orderBy('created_at', 'desc')->first();

        return view('front.legal')->with('text', $text);
    }

    // Módulo Adquisiciones y Proveedores
    public function acquisitions()
    {
        return view('front.acquisitions.index');
    }

    /* PARA PROPÓSITOS DE DESARROLLO */
    public function building()
    {
        return view('front.building');
    }

    // Pantallas Tesorería
    public function treasury()
    {
        return view('front.treasury');
    }

    // Pantallas SARE
    public function sare()
    {
        return view('front.sare');
    }

    // Pantallas Desarrollo Urbano
    public function urbanDev()
    {
        return view('front.urban_dev.index');
    }

    public function urbanDevProcedures()
    {
        return view('front.urban_dev.procedures');
    }

    public function urbanDevServices()
    {
        return view('front.urban_dev.services');
    }

    public function urbanDevDirectory()
    {
        return view('front.urban_dev.directory');
    }

    public function urbanDevContacts($type)
    {
        $workers = collect();
        $title = '';

        switch ($type) {
            case 'inspectors':
                $workers = \App\Models\UrbanDevWorker::inspectors()
                    ->orderBy('name', 'asc')
                    ->get();
                $title = 'Inspectores';
                break;

            case 'auditors':
                $workers = \App\Models\UrbanDevWorker::auditors()
                    ->orderBy('name', 'asc')
                    ->get();
                $title = 'Fiscalización';

                return view('front.urban_dev.auditors_detail')->with([
                    'type' => $type,
                    'workers' => $workers,
                    'title' => $title
                ]);
                break;

            case 'experts':
                $workers = \App\Models\UrbanDevWorker::experts()
                    ->orderBy('name', 'asc')
                    ->get();
                $title = 'Peritos';
                break;

            default:
                abort(404);
        }

        return view('front.urban_dev.contacts')->with([
            'type' => $type,
            'workers' => $workers,
            'title' => $title
        ]);
    }

    public function urbanDevDetail($tramite)
    {
        return view('front.urban_dev.show')->with('tramite', $tramite);
    }

    // Pantalla Casa de la Mujer
    public function casaMujer()
    {
        return view('front.casa_mujer');
    }


    // Pantallas DIF
    public function dif()
    {
        $fav_posts = Blog::where('is_fav', true)->where('category', 'DIF')->orderBy('updated_at', 'desc')->limit(3)->get();

        $banners = DIFBanner::where('is_active', true)->orderBy('priority', 'asc')->get();

        $category = 'Dif';

        return view('front.dif')->with('fav_posts', $fav_posts)->with('banners', $banners)->with('category', $category);
    }

    // Pantallas Blog/Noticias
    public function blog()
    {
        $fav_posts = Blog::where('is_fav', true)
            ->where('category', '!=', 'DIF')
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();

        $posts = Blog::where('category', '!=', 'DIF')
            ->orderBy('updated_at', 'desc')
            ->take(6)
            ->get();

        $mode = 1;

        $categories = ['General', 'Turismo', 'Eventos'];

        return view('front.blog.index')->with([
            'posts' => $posts,
            'fav_posts' => $fav_posts,
            'mode' => $mode,
            'categories' => $categories
        ]);
    }

    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        return view('front.blog.detail')->with('blog', $blog);
    }

    public function blogList($category)
    {
        $posts = Blog::orderBy('updated_at', 'desc')->where('category', $category)->paginate(8);
        $mode = 1;

        $category = $category;

        return view('front.blog.list')->with([
            'posts' => $posts,
            'mode' => $mode,
            'category' => $category
        ]);
    }

    public function blogAll()
    {
        $posts = Blog::orderBy('updated_at', 'desc')->paginate(8);
        $mode = 1;

        $category = '';

        return view('front.blog.list')->with([
            'posts' => $posts,
            'mode' => $mode,
            'category' => $category
        ]);
    }

    // Pantallas Contraloria
    public function contraloria()
    {
        return view('front.contraloria.index');
    }

    public function contraloriaFaults()
    {
        return view('front.contraloria.faults');
    }

    public function contraloriaFaultsNotSerious()
    {
        return view('front.contraloria.faults_not_serious');
    }

    public function contraloriaFaultsNotSeriousRules()
    {
        return view('front.contraloria.faults_not_serious_rules');
    }

    public function contraloriaFaultsSerious()
    {
        return view('front.contraloria.faults_serious');
    }

    public function contraloriaDeclaration()
    {
        return view('front.contraloria.declaration');
    }

    public function contraloriaReception()
    {
        return view('front.contraloria.reception');
    }

    public function contraloriaSuggestions()
    {
        return view('front.contraloria.suggestions');
    }

    public function contraloriaPrivacyNotice()
    {
        return view('front.contraloria.privacy_notice');
    }
    

    // Pantallas DenunciaNet
    public function denunciaNet()
    {
        return view('front.citizen_complain.index');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img('flat')], 200);
    }

    public function desarrolloInstitucional()
    {

        $banners = InstitucionalDevelopmentBanner::where('is_active', true)->orderBy('priority', 'asc')->get();

        return view('front.institutional_development')->with('banners', $banners);
    }

    public function registroMunicipalDeRegulaciones()
    {
        $mode = 1;

        return view('front.regulaciones_municipales');
    }

    public function showRegulacion($id)
    {
        $regulation = MunicipalRegulation::findOrFail($id);

        return view('front.regulaciones_municipales.show')->with('regulation', $regulation);
    }

    public function tramitesYServicios()
    {
        return view('front.tramites_y_servicios');
    }

    public function showTramite($id)
    {
        $request = ServiceRequest::findOrFail($id);

        return view('front.tramites_y_servicios.show')->with('request', $request);
    }

    public function implan()
    {
        $banners = ImplanBanner::where('is_active', true)->orderBy('priority', 'asc')->get();

        return view('front.implan.index')->with('banners', $banners);
    }

    public function implanWhoWeAre()
    {
        return view('front.implan.who_we_are');
    }

    public function implanBlog()
    {
        $planos = ImplanBlog::where('type', 'Plano')->get();
        $capas = ImplanBlog::where('type', 'Capa')->get();

        return view('front.implan.blog.index')->with([
            'planos' => $planos,
            'capas' => $capas,
        ]);
    }

    public function implanProjects()
    {
        $projects = ImplanProject::where('is_active', true)->get();

        return view('front.implan.projects.index')->with('projects', $projects);
    }

    public function implanProjectDetail($slug)
    {
        $project = ImplanProject::where('slug', $slug)->first();

        return view('front.implan.projects.show')->with('project', $project);
    }

    public function implanAchievements()
    {
        $achievements = ImplanAchievement::where('is_active', true)->get();

        return view('front.implan.achievements')->with('achievements', $achievements);
    }

    public function municipalInspection()
    {
        return view('front.municipal_inspection');
    }

    public function urbanCouncil()
    {
        return view('front.urban_council');
    }

    public function councilAttributions()
    {
        return view('front.council_attributions');
    }

    public function actasConsejo()
    {
        return view('front.council_minutes');
    }
}
