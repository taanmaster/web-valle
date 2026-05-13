<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Carbon\Carbon;

// Modelos
use App\Models\Notification;
use App\Models\EventsBlog;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function home()
    {
        $events = EventsBlog::where('is_active', true)
            ->orderBy('published_at', 'asc')
            ->take(4)
            ->get();

        return view('home', compact('events'));
    }

    public function adminProfile()
    {
        return view('profile');
    }

    public function adminConfig()
    {
        return view('configurations');
    }

    public function createNote(Request $request){
        $log = new Notification([
            'action_by' => Auth::user()->id,
            'model_action' => $request->model_action,
            'model_id' => $request->model_id,
            'type' => $request->type,
            'data' => $request->data,
            'note' => $request->note,
            'is_hidden' => false
        ]);
        
        $log->save();

        return redirect()->back()->with('success', 'Nota creada exitosamente');
    }
}
