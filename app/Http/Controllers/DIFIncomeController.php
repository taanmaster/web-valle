<?php

namespace App\Http\Controllers;

use App\Models\DIFIncome;
use Illuminate\Http\Request;

class DIFIncomeController extends Controller
{
    public function index()
    {
        return view('dif.incomes.index');
    }

    public function create()
    {
        $mode = 0;

        return view('dif.incomes.create')->with('mode', $mode);
    }

    public function show($id)
    {
        $mode = 1;
        $income = DIFIncome::findOrFail($id);

        return view('dif.incomes.show', [
            'mode' => $mode,
            'income' => $income,
        ]);
    }

    public function edit($id)
    {
        $mode = 2;
        $income = DIFIncome::findOrFail($id);

        return view('dif.incomes.edit', [
            'mode' => $mode,
            'income' => $income,
        ]);
    }

    public function destroy($id)
    {
        $income = DIFIncome::findOrFail($id);
        $income->delete();

        return view('dif.incomes.index')->with('success', 'Ingreso eliminado correctamente.');
    }
}
