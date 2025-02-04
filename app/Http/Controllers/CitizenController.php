<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\Citizen;
use App\Models\CitizenFile;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index()
    {
        $citizens = Citizen::paginate(10);

        return view('citizens.index')->with('citizens', $citizens);
    }

    public function create()
    {
        return view('citizens.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $citizen = Citizen::create([
            'name' => $request->name,
            'description' => $request->description,
            'document_number' => $request->document_number,
            'type' => $request->type,
            'meeting_date' => $request->meeting_date,
        ]);

        // Guardar archivo
        if ($request->hasFile('document')) {
            // Guardar datos en la base de datos
            $file = new CitizenFile;
            $file->citizen_id = $citizen->id;
            $file->name = $request->name;
            $file->slug = Str::slug('gaceta_' .  $request->name . '_' . $request->document_number);
            $file->description = $request->description;

            $document = $request->file('document');
            $filename = 'gaceta_' .  $request->name . '_' . $request->document_number . '.' . $document->getClientOriginalExtension();
            $location = public_path('files/citizens/');
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
        $citizen = Citizen::find($id);

        return view('citizens.show')->with('citizen', $citizen);
    }

    public function edit($id)
    {
        $citizen = Citizen::find($id);

        return view('citizens.edit')->with('citizen', $citizen);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $citizen = Citizen::find($id);

        $citizen->update([
            'name' => $request->name,
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
        $citizen = Citizen::find($id);
        $citizen->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
