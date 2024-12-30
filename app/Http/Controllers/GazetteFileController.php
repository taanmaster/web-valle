<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

use App\Models\Gazette;
use App\Models\GazetteFile;
use Illuminate\Http\Request;

class GazetteFileController extends Controller
{
    /* Vinculado a Gazette */
    /*
    * Generalmente las gacetas son de 1 solo documento
    * pero existen casos donde se adjuntas múltiples.
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
        $gazette = Gazette::find($request->gazette_id);

        // Guardar datos en la base de datos
        $file = new GazetteFile;
        $file->gazette_id = $request->gazette_id;
        $file->name = $request->name;
        $file->slug = Str::slug('gaceta_' .  $request->name . '_' . $gazette->document_number);
        $file->description = $request->description;

        $document = $request->file('document');
        $filename = 'gaceta_' .  $request->name . '_' . $gazette->document_number . '.' . $document->getClientOriginalExtension();
        $location = public_path('files/gazettes/');
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

    public function show(GazetteFile $gazetteFile)
    {
        //
    }

    public function edit(GazetteFile $gazetteFile)
    {
        //
    }

    public function update(Request $request, GazetteFile $gazetteFile)
    {
        //
    }

    public function destroy($id)
    {
        $file = GazetteFile::findOrFail($id);

        unlink(public_path() .  '/files/gazettes/' . $file->filename);
        
        $file->delete();

        Session::flash('exito', 'El archivo ha sido borrado exitosamente.');

        return redirect()->back();
    }
}
