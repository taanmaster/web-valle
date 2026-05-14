<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainingDownloadableController extends Controller
{
    public function index()
    {
        return view('training-downloadable.index');
    }
}
