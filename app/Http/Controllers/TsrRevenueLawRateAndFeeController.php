<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TsrRevenueLawRateAndFee;

use Illuminate\Http\Request;

class TsrRevenueLawRateAndFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rates = TsrRevenueLawRateAndFee::paginate(10);

        return view('tsr_revenue_law_rates_and_fees.index')->with('rates', $rates);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TsrRevenueLawRateAndFee $tsrRevenueLawRateAndFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrRevenueLawRateAndFee $tsrRevenueLawRateAndFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrRevenueLawRateAndFee $tsrRevenueLawRateAndFee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rate = TsrRevenueLawRateAndFee::find($id);

        // Eliminar autorización
        $rate->delete();

        // Mensaje de sesión
        Session::flash('success', 'Tarifa eliminada correctamente.');

        return redirect()->back();
    }
}
