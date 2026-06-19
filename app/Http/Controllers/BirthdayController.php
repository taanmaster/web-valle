<?php

namespace App\Http\Controllers;

use App\Models\Birthday;

class BirthdayController extends Controller
{
    public function index()
    {
        // Fotos por mes (1-12), null si el mes no tiene registro
        $photos = Birthday::pluck('photo', 'month');

        $months = collect(Birthday::MONTHS)->map(fn ($name, $num) => [
            'num'   => $num,
            'name'  => $name,
            'photo' => $photos[$num] ?? null,
        ])->values();

        return view('birthday.index', [
            'months'       => $months,
            'currentMonth' => now()->month,
        ]);
    }

    public function manage()
    {
        return view('birthday.admin');
    }
}
