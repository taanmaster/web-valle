<?php

namespace App\Http\Controllers;

use App\Models\TsrAccountDueIncome;
use Illuminate\Http\Request;

class TsrAccountDueIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tsr_accounts_due.incomes.index');
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
    public function show(TsrAccountDueIncome $tsrAccountDueIncome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrAccountDueIncome $tsrAccountDueIncome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrAccountDueIncome $tsrAccountDueIncome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TsrAccountDueIncome $tsrAccountDueIncome)
    {
        //
    }
}
