<?php

namespace App\Http\Controllers;

// Ayudantes
use Session;
use Str;
use Auth;

// Modelos
use App\Models\DIFLocation as Location;
use App\Models\DIFLocationAssignment as Assignment;
use App\Models\Notification;

/* Notificaciones */
use App\Services\NotificationService;

use Illuminate\Http\Request;

class DIFLocationController extends Controller
{
    private $notification;

    public function __construct()
    {
        $this->notification = new NotificationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Location::query();

        if (request('search')) {
            $search = request('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('street_name', 'LIKE', "%{$search}%")
                  ->orWhere('street_num', 'LIKE', "%{$search}%")
                  ->orWhere('zip_code', 'LIKE', "%{$search}%")
                  ->orWhere('colony', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%");
        }

        $locations = $query->paginate(30);

        return view('dif.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('dif.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'street_name' => 'required|max:255',
            'street_num' => 'required|max:50',
            'zip_code' => 'required|max:10',
            'colony' => 'nullable|max:255',
            'phone' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'type' => 'required|max:100',
        ]);

        $location = Location::create([
            'name' => $request->name,
            'street_name' => $request->street_name,
            'street_num' => $request->street_num,
            'zip_code' => $request->zip_code,
            'colony' => $request->colony,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type,
        ]);

        // Notificación
        $type = 'location';
        $by = Auth::user();
        $data = 'Creó una locación en el sistema';
        $model_action = "create";
        $model_id = $location->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);
        
        Session::flash('success', 'Locación guardada correctamente.');

        return redirect()->route('dif.locations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $location = Location::findOrFail($id);
        $logs = Notification::where('type', 'location')->where('model_id', $id)->get();
        $assignments = Assignment::where('location_id', $location->id)->get();

        // Cargar listas para el modal: programas y asistencias
        $programs = \App\Models\DIFProgram::orderBy('name')->get();
        $assistances = \App\Models\DIFSocialAssistance::orderBy('name')->get();

        return view('dif.locations.show', compact('location', 'logs', 'assignments', 'programs', 'assistances'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('dif.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'street_name' => 'required|max:255',
            'street_num' => 'required|max:50',
            'zip_code' => 'required|max:10',
            'colony' => 'nullable|max:255',
            'phone' => 'nullable|max:50',
            'email' => 'nullable|email|max:255',
            'type' => 'required|max:100',
        ]);

        $location = Location::findOrFail($id);
        
        $location->update([
            'name' => $request->name,
            'street_name' => $request->street_name,
            'street_num' => $request->street_num,
            'zip_code' => $request->zip_code,
            'colony' => $request->colony,
            'phone' => $request->phone,
            'email' => $request->email,
            'type' => $request->type,
        ]);

        // Notificación
        $type = 'location';
        $by = Auth::user();
        $data = 'editó una locación en el sistema';
        $model_action = "update";
        $model_id = $location->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        Session::flash('success', 'Locación editada exitosamente.');

        return redirect()->route('dif.locations.show', $location->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        // Notificación
        $type = 'location';
        $by = Auth::user();
        $data = 'eliminó una locación en el sistema';
        $model_action = "destroy";
        $model_id = $location->id;

        $this->notification->send($type, $by ,$data, $model_action, $model_id);

        $location->delete();

        Session::flash('success', 'Locación eliminada de manera exitosa.');
        return redirect()->route('dif.locations.index');
    }
}
