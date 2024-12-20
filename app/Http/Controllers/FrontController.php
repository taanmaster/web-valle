<?php

namespace App\Http\Controllers;

use Session;

use App\Models\Gazette;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('index');
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
}
