<?php

namespace App\Http\Controllers;

use App\Models\DIFExpense;
use Illuminate\Http\Request;

class DIFExpenseController extends Controller
{

    public function index()
    {
        return view('dif.expenses.index');
    }

    public function create()
    {
        $mode = 0;

        return view('dif.expenses.create')->with('mode', $mode);
    }

    public function show($id)
    {
        $mode = 1;
        $expense = DIFExpense::findOrFail($id);

        return view('dif.expenses.show', [
            'mode' => $mode,
            'expense' => $expense,
        ]);
    }

    public function edit($id)
    {
        $mode = 2;
        $expense = DIFExpense::findOrFail($id);

        return view('dif.expenses.edit', [
            'mode' => $mode,
            'expense' => $expense,
        ]);
    }

    public function destroy($id)
    {
        $expense = DIFExpense::findOrFail($id);
        $expense->delete();

        return view('dif.expenses.index')->with('success', 'Salida eliminada correctamente.');
    }
}
