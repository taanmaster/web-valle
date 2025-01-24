<?php

namespace App\Http\Controllers;

use App\Models\CitizenFile;
use Illuminate\Http\Request;

class CitizenFileController extends Controller
{
    /* Vinculado a Citizen */
    /*
    * Los ciudadanos tienen un repositorio de documentación para uso del Municipio
    */

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $citizen = Citizen::find($request->citizen_id);

        // Guardar datos en la base de datos
        $file = new CitizenFile;
        $file->citizen_id = $request->citizen_id;
        $file->name = $request->name;
        $file->slug = Str::slug('doc_' .  $request->name . '_' . $citizen->id);
        $file->description = $request->description;

        $document = $request->file('document');
        $filename = 'doc_' .  $request->name . '_' . $citizen->id . '.' . $document->getClientOriginalExtension();
        $location = public_path('files/citizens/');
        $document->move($location, $filename);

        $file->filename = $filename;
        $file->file_extension = $document->getClientOriginalExtension();
        $file->uploaded_by = Auth::user()->id;

        $file->save();

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function show(CitizenFile $citizenFile)
    {
        //
    }

    public function edit(CitizenFile $citizenFile)
    {
        //
    }

    public function update(Request $request, CitizenFile $citizenFile)
    {
        //
    }

    public function destroy($id)
    {
        $file = CitizenFile::findOrFail($id);

        unlink(public_path() .  '/files/citizens/' . $file->filename);
        
        $file->delete();

        Session::flash('exito', 'El archivo ha sido borrado exitosamente.');

        return redirect()->back();
    }
}
