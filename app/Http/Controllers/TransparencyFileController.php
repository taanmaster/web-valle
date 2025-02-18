<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TransparencyFile;

use Illuminate\Http\Request;

class TransparencyFileController extends Controller
{
    public function index()
    {
        $transparency_files = TransparencyFile::paginate(10);

        return view('transparency_files.index')->with('transparency_files', $transparency_files);
    }

    public function create()
    {
        return view('transparency_files.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $transparency_file = TransparencyFile::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show($id)
    {
        $transparency_file = TransparencyFile::find($id);

        return view('transparency_files.show')->with('transparency_file', $transparency_file);
    }

    public function edit($id)
    {
        $transparency_file = TransparencyFile::find($id);

        return view('transparency_files.edit')->with('transparency_file', $transparency_file);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $transparency_file = TransparencyFile::find($id);

        $transparency_file->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $transparency_file = TransparencyFile::find($id);
        $transparency_file->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
