<?php

namespace App\Http\Controllers;

use App\Models\Birthday;

class BirthdayController extends Controller
{
    public function index()
    {
        $birthdays = Birthday::orderBy('birthday_date')->get();

        return view('birthday.index', compact('birthdays'));
    }

    public function manage()
    {
        return view('birthday.admin');
    }
}
