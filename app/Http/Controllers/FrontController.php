<?php

namespace App\Http\Controllers;

use Str;
use Auth;
use Session;
use Carbon\Carbon;

use App\Models\Gazette;
use App\Models\legalText;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
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

        return view('front.index')->with([
            'gazettes' => $gazettes,
            'ordinary_gazette_sessions' => $ordinary_gazette_sessions,
            'solemn_gazette_sessions' => $solemn_gazette_sessions,
            'extraordinary_gazette_sessions' => $extraordinary_gazette_sessions,
            'dates' => $dates
        ]);
    }

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

    public function filterByDate($type, $date)
    {
        Carbon::setLocale('es');

        if($type == 'all'){
            $gazettes = Gazette::whereYear('meeting_date', '=', Carbon::createFromFormat('Y-m', $date)->year)
            ->whereMonth('meeting_date', '=', Carbon::createFromFormat('Y-m', $date)->month)
            ->with('files')
            ->orderBy('meeting_date', 'desc')
            ->get();
        }else{
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
}
