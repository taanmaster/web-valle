<?php

namespace App\Http\Controllers;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;
use Carbon\Carbon;

// Modelos
use App\Models\Event;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();
        
        // Búsqueda por nombre o ubicación
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('location', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        
        // Filtrado por estado
        if ($request->has('status') && $request->status) {
            $now = Carbon::now();
            
            switch ($request->status) {
                case 'upcoming':
                    $query->where('date_start', '>', $now);
                    break;
                case 'ongoing':
                    $query->where('date_start', '<=', $now)
                          ->where(function($q) use ($now) {
                              $q->whereNull('date_end')
                                ->orWhere('date_end', '>=', $now);
                          });
                    break;
                case 'past':
                    $query->where(function($q) use ($now) {
                        $q->whereNotNull('date_end')
                          ->where('date_end', '<', $now);
                    });
                    break;
            }
        }
        
        // Ordenar por fecha de inicio, eventos próximos primero
        $query->orderBy('date_start', 'asc');
        
        $events = $query->paginate(30)->withQueryString();
        
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        //Validar
        $request->validate([
            'name' => 'required|max:255',
            'date_start' => 'required|date',
            'date_end' => 'nullable|date',
            'location' => 'required|max:255',
            'blog_url' => 'nullable|url',
        ]);

        // Guardar datos en la base de datos
        $event = new Event;

        $event->name = $request->name;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->location = $request->location;
        $event->blog_url = $request->blog_url;

        $event->save();

        // Mensaje de session
        Session::flash('success', 'Se creó el evento con éxito.');

        // Enviar a vista
        return redirect()->route('events.index');
    }

    public function show($id)
    {
        $event = Event::find($id);

        return view('events.show')->with('event', $event);
    }

    public function edit($id)
    {
        $event = Event::find($id);

        return view('events.edit')->with('event', $event);
    }

    public function update(Request $request, $id)
    {
        // Validar
        $request->validate([
            'name' => 'required|max:255',
            'date_start' => 'required|date',
            'date_end' => 'nullable|date',
            'location' => 'required|max:255',
            'blog_url' => 'nullable|url',
        ]);

        // Guardar datos en la base de datos
        $event = Event::find($id);

        $event->name = $request->name;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->location = $request->location;
        $event->blog_url = $request->blog_url;

        $event->save();

        // Mensaje de session
        Session::flash('success', 'El evento se ha editado satisfactoriamente.');

        // Enviar a vista
        return redirect()->route('events.show', $event->id);
    }

    public function status(Request $request)
    {
        // Guardar datos en la base de datos
        $event = Event::find($request->id);

        if($event->is_active == true) {
            $event->is_active = false;
        }else {
            $event->is_active = true;
        }

        $event->save();

        // Mensaje de session
        Session::flash('success', 'El evento ha cambiado de estado.');

        // Enviar a vista
        return redirect()->route('events.index');
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        $event->delete();

        Session::flash('success', 'El evento se eliminó correctamente.');

        return redirect()->route('events.index');
    }
}
