<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\Gazette;
use App\Models\GazetteFile;

use Illuminate\Http\Request;

class GazetteController extends Controller
{
    /* Categorización PreCargada */
    /*
    * Campo type es "string"
    * Categorias para campo type
    * -- Sesiones Solemnes = solemn
    * -- Sesiones Ordinarias = ordinary
    * -- Sesiones Extraordinarias = extraordinary
    */

    public function index()
    {
        $gazettes = Gazette::paginate(10);

        return view('gazettes.index')->with('gazettes', $gazettes);
    }

    public function create()
    {
        return view('gazettes.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $gazette = Gazette::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'document_number' => $request->document_number,
            'type' => $request->type,
            'meeting_date' => $request->meeting_date,
        ]);

        // Guardar archivo
        if ($request->hasFile('document')) {
            // Guardar datos en la base de datos
            $file = new GazetteFile;
            $file->gazette_id = $gazette->id;
            $file->name = $request->name;
            $file->slug = Str::slug('gaceta_' .  $request->name . '_' . $request->document_number);
            $file->description = $request->description;

            $document = $request->file('document');
            $filename = 'gaceta_' .  $request->name . '_' . $request->document_number . '.' . $document->getClientOriginalExtension();
            $location = public_path('files/gazettes/');
            $document->move($location, $filename);

            $file->filename = $filename;
            $file->file_extension = $document->getClientOriginalExtension();
            $file->uploaded_by = Auth::user()->id;

            $file->save();
        }

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $gazette = Gazette::find($id);

        return view('gazettes.show')->with('gazette', $gazette);
    }

    public function edit($id)
    {
        $gazette = Gazette::find($id);

        return view('gazettes.edit')->with('gazette', $gazette);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $gazette = Gazette::find($id);

        $gazette->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'document_number' => $request->document_number,
            'type' => $request->type,
            'meeting_date' => $request->meeting_date,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $gazette = Gazette::find($id);
        $gazette->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
