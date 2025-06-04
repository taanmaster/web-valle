<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TsrAccountsDueController extends Controller
{
    public function dashboard()
    {
        return view('tsr_accounts_due.dashboard');
    }

    public function cashbox()
    {
        return view('tsr_accounts_due.cashbox');
    }
}
