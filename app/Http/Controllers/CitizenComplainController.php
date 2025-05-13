<?php

namespace App\Http\Controllers;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;

use App\Models\CitizenComplain;
use Illuminate\Http\Request;


class CitizenComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complains = CitizenComplain::paginate(10);


        return view('complains.index')->with([
            'complains' => $complains,
        ]);
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
    public function show(CitizenComplain $citizenComplain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CitizenComplain $citizenComplain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CitizenComplain $citizenComplain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CitizenComplain $citizenComplain)
    {
        //
    }
}
