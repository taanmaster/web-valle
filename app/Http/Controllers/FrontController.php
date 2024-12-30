<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Models\Gazette;
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

        return view('front.index')->with([
            'gazettes' => $gazettes,
            'dates' => $dates
        ]);
    }

    public function gazetteList()
    {
        $gazettes = Gazette::orderBy('id', 'desc')->paginate(10);
        
        return view('front.gazette.index')
        ->with('gazettes', $gazettes);
    }

    public function gazetteDetail($slug)
    {   
        $gazette = Gazette::where('slug', '=', $slug)->first();

        return view('front.gazette.detail')
        ->with('gazette', $gazette);
    }

    public function filterByDate($date)
    {
        Carbon::setLocale('es');
        $gazettes = Gazette::whereYear('meeting_date', '=', Carbon::createFromFormat('Y-m', $date)->year)
                           ->whereMonth('meeting_date', '=', Carbon::createFromFormat('Y-m', $date)->month)
                           ->with('files')
                           ->orderBy('meeting_date', 'desc')
                           ->get();

        $dates = Gazette::selectRaw('DATE_FORMAT(meeting_date, "%Y-%m") as date')
                        ->groupBy('date')
                        ->orderBy('date', 'desc')
                        ->get()
                        ->pluck('date')
                        ->map(function ($date) {
                            return Carbon::createFromFormat('Y-m', $date);
                        });

        return view('front.index')->with([
            'gazettes' => $gazettes,
            'dates' => $dates
        ]);
    }
}
