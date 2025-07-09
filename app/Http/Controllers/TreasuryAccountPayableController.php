<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TreasuryAccountPayableController extends Controller
{
    public function index()
    {
        return view('treasury_account_payable.dashboard');
    }
}
