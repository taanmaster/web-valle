<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Intervention\Image\Facades\Image as Image;

// Modelos
use App\Models\TransparencyDependency;
use App\Models\TransparencyFile;
use App\Models\User;

use Illuminate\Http\Request;

class TreasuryDependencyController extends Controller
{
    public function index()
    {
        $transparency_dependencies = TransparencyDependency::where('belongs_to_treasury', true)->paginate(10);

        return view('treasury_dependencies.index')->with('transparency_dependencies', $transparency_dependencies);
    }
}
