<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TsrAccountsDueController extends Controller
{
    public function dashboard()
    {
        return view('tsr_accounts_due.dashboard');
    }

    public function profiles()
    {
        return view('tsr_accounts_due.profiles.index');
    }

    public function integerRegisters()
    {
        return view('tsr_accounts_due.integer_registers.index');
    }

    public function treasuryCash()
    {
        return view('tsr_accounts_due.treasury_cash.index');
    }

    public function payments()
    {
        return view('tsr_accounts_due.payments.index');
    }

    public function receipts()
    {
        return view('tsr_accounts_due.receipts.index');
    }

    public function reconciliations()
    {
        return view('tsr_accounts_due.reconciliations.index');
    }
}
