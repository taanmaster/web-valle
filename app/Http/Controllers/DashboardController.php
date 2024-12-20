<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function adminProfile()
    {
        return view('profile');
    }

    public function adminConfig()
    {
        return view('configurations');
    }
}
