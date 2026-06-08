<?php

namespace App\Http\Controllers;

use App\Models\TsrAccountDueIncomeReceipt;
use App\Models\TsrAccountDueIncome;
use Illuminate\Http\Request;

class TsrAccountDueIncomeReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $income = TsrAccountDueIncome::findOrFail($id);

        return redirect()
            ->route('account_due_incomes.show', $income->id)
            ->with('message', 'Para generar el recibo utiliza el modal dentro del detalle de ingreso.');
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
    public function show(TsrAccountDueIncomeReceipt $tsrAccountDueIncomeReceipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TsrAccountDueIncomeReceipt $tsrAccountDueIncomeReceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TsrAccountDueIncomeReceipt $tsrAccountDueIncomeReceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TsrAccountDueIncomeReceipt $tsrAccountDueIncomeReceipt)
    {
        //
    }
}
