<?php

namespace App\Http\Controllers;


use DB;
use Auth;
use Session;
use Carbon\Carbon;

use App\Models\Gazette;
use App\Models\GazetteFile;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function gazetteQuery(Request $request)
    {
        $search_query = $request->input('query');

        $gazettes = Gazette::where('document_number', 'LIKE', "%{$search_query}%")
            ->orWhere('name', 'LIKE', "%{$search_query}%")
            ->paginate(30);

        return view('gazettes.query')->with('gazettes', $gazettes);
    }
}
