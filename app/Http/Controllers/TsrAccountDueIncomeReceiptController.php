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
        $mode = 0;

        $income = TsrAccountDueIncome::findOrFail($id);

        return view('tsr_accounts_due.incomes_receipts.create')->with('mode', $mode)->with('income', $income);
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
