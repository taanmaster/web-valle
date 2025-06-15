<?php

namespace App\Http\Controllers;

use App\Models\TsrAccountDueIncome;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

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
        $mode = 0; // Create mode

        return view('tsr_accounts_due.incomes.create')->with('mode', $mode);
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
    public function show($id)
    {
        $mode = 1; // Show mode

        $income = TsrAccountDueIncome::findOrFail($id);

        return view('tsr_accounts_due.incomes.show')->with('mode', $mode)->with('income', $income);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mode = 2; // Edit mode

        $income = TsrAccountDueIncome::findOrFail($id);

        return view('tsr_accounts_due.incomes.edit')->with('mode', $mode)->with('income', $income);
    }

    public function close($id)
    {
        $pdf = PDF::loadView('pdf')->setPaper('A4');

        return $pdf->download();
    }

    public function update(Request $request, TsrAccountDueIncome $tsrAccountDueIncome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
