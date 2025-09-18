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
        return view('dif.expenses.create');
    }

    public function show($id)
    {
        return view('dif.expenses.show');
    }

    public function edit($id)
    {
        return view('dif.expenses.edit');
    }

    public function destroy($id)
    {
        return view('dif.expenses.index');
    }
}
