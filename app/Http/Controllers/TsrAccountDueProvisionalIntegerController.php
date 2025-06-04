<?php

namespace App\Http\Controllers;

use App\Models\TsrAccountDueProvisionalInteger;
use Illuminate\Http\Request;

class TsrAccountDueProvisionalIntegerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tsr_accounts_due.provisional_registers.index');
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
    public function show(TsrAccountDueProvisionalInteger $tsrAccountDueProvisionalInteger)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrAccountDueProvisionalInteger $tsrAccountDueProvisionalInteger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrAccountDueProvisionalInteger $tsrAccountDueProvisionalInteger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TsrAccountDueProvisionalInteger $tsrAccountDueProvisionalInteger)
    {
        //
    }
}
