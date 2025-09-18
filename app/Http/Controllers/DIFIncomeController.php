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
        return view('dif.incomes.create');
    }

    public function show($id)
    {
        return view('dif.incomes.show');
    }

    public function edit($id)
    {
        return view('dif.incomes.edit');
    }

    public function destroy($id)
    {
        return view('dif.incomes.index');
    }
}
