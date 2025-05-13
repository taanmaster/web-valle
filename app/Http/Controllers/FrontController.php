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

// Modelos Blog
use App\Models\Blog;

// Modelos Denuncia Ciudadana
use App\Models\CitizenComplaint;
use App\Models\CitizenComplaintFile;

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
        // Cargar las dependencias que quieren mostrar en la página de inicio.
        $dependencies = TransparencyDependency::where('in_index', true)->get();

        $banners = Banner::where('is_active', true)->orderBy('priority', 'asc')->get();
        $popup = Popup::where('is_active', true)->orderBy('updated_at', 'desc')->first();
        $headerbands = Headerband::where('is_active', true)->orderBy('priority', 'asc')->get();

        //Cargar Dependencias regulatorias
        $regulation_dependencies = RegulatoryAgendaDependency::all();

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
            'regulation_dependencies' => $regulation_dependencies
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
    public function dependencyList()
    {
        $dependencies = TransparencyDependency::where('belongs_to_treasury', false)->orderBy('name', 'asc')->get();

        return view('front.dependencies.index')
            ->with('dependencies', $dependencies);
    }

    public function dependencyDetail($slug)
    {
        $dependency = TransparencyDependency::where('slug', '=', $slug)->first();

        return view('front.dependencies.detail')
            ->with('dependency', $dependency);
    }

    // Módulo Obligaciones
    public function obligationDetail($slug)
    {
        $obligation = TransparencyObligation::where('slug', '=', $slug)->first();

        Carbon::setLocale('es');

        $documents = TransparencyDocument::where('obligation_id', $obligation->id)->orderBy('year', 'desc')->get();

        $dates = TransparencyDocument::selectRaw('YEAR(year) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get()
            ->pluck('year')
            ->map(function ($year) {
                return Carbon::createFromDate($year, 1, 15);
            });

        return view('front.dependencies.obligation_detail')
            ->with('obligation', $obligation)
            ->with('documents', $documents)
            ->with('dates', $dates);
    }

    // Módulo Documentos
    public function filterTransparencyDocumentByDate($slug, $date)
    {
        $obligation = TransparencyObligation::where('slug', '=', $slug)->first();

        Carbon::setLocale('es');

        $documents = TransparencyDocument::where('obligation_id', $obligation->id)->where('year', '=', $date)->orderBy('year', 'desc')->get();

        $dates = TransparencyDocument::selectRaw('YEAR(year) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get()
            ->pluck('year')
            ->map(function ($year) {
                return Carbon::createFromDate($year, 1, 15);
            });

        return view('front.dependencies.obligation_detail')->with([
            'obligation' => $obligation,
            'documents' => $documents,
            'dates' => $dates
        ]);
    }

    // Módulo Agenda Regulatoria
    public function regulatoryAgenda()
    {
        $dependencies = RegulatoryAgendaDependency::all();

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

    /* PARA PROPÓSITOS DE DESARROLLO */
    public function building()
    {
        return view('front.building');
    }

    public function treasury()
    {
        return view('front.treasury');
    }

    public function sare()
    {
        return view('front.sare');
    }

    public function blog()
    {
        $fav_posts = Blog::where('is_fav', true)->orderBy('updated_at', 'desc')->limit(3)->get();
        $posts = Blog::orderBy('updated_at', 'desc')->take(6)->get();

        $mode = 0;

        return view('front.blog.index')->with([
            'posts' => $posts,
            'fav_posts' => $fav_posts,
            'mode' => $mode
        ]);
    }

    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        return view('front.blog.detail')->with('blog', $blog);
    }

    public function blogList()
    {
        $posts = Blog::orderBy('updated_at', 'desc')->paginate(8);
        $mode = 1;

        return view('front.blog.list')->with([
            'posts' => $posts,
            'mode' => $mode
        ]);
    }

    public function denunciaNet()
    {
        return view('front.citizen_complain.index');
    }
}
