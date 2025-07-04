<?php

namespace App\Http\Controllers;

// Ayudantes
use DB;
use Auth;
use Session;
use Carbon\Carbon;

// Modelos
use App\Models\Gazette;
use App\Models\GazetteFile;

use App\Models\Citizen;
use App\Models\FinancialSupport;
use App\Models\FinancialSupportType;

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

    public function citizenQuery(Request $request)
    {
        $search_query = $request->input('query');

        // Si la petición es AJAX, devolver JSON
        if ($request->ajax() || $request->wantsJson()) {
            $citizens = Citizen::where('name', 'LIKE', "%{$search_query}%")
                ->orWhere('first_name', 'LIKE', "%{$search_query}%")
                ->orWhere('last_name', 'LIKE', "%{$search_query}%")
                ->orWhere('curp', 'LIKE', "%{$search_query}%")
                ->orWhere('phone', 'LIKE', "%{$search_query}%")
                ->orWhere('email', 'LIKE', "%{$search_query}%")
                ->limit(20)
                ->get()
                ->map(function ($citizen) {
                    return [
                        'id' => $citizen->id,
                        'name' => $citizen->name,
                        'curp' => $citizen->curp,
                        'phone' => $citizen->phone,
                        'email' => $citizen->email,
                        'address' => $citizen->address,
                    ];
                });

            return response()->json([
                'success' => true,
                'patients' => $citizens
            ]);
        }

        // Si no es AJAX, devolver vista tradicional
        $citizens = Citizen::where('name', 'LIKE', "%{$search_query}%")
            ->orWhere('first_name', 'LIKE', "%{$search_query}%")
            ->orWhere('last_name', 'LIKE', "%{$search_query}%")
            ->paginate(30);

        return view('citizens.query')->with('citizens', $citizens);
    }

    public function financial_supportsQuery(Request $request)
    {
        $search_query = $request->input('query');

        $financial_supports = FinancialSupport::whereHas('citizen', function($query) use ($search_query) {
            $query->where('name', 'LIKE', "%{$search_query}%")
                ->orWhere('first_name', 'LIKE', "%{$search_query}%")
                ->orWhere('last_name', 'LIKE', "%{$search_query}%");
        })->orWhere('receipt_num', 'LIKE', "%{$search_query}%")
        ->paginate(30);

        return view('financial_supports.query')->with('financial_supports', $financial_supports);
    }

    public function financial_support_typesQuery(Request $request)
    {
        $search_query = $request->input('query');

        $financial_support_types = FinancialSupportType::where('name', 'LIKE', "%{$search_query}%")
            ->paginate(30);

        return view('financial_support_types.query')->with('financial_support_types', $financial_support_types);
    }
}
