<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;

// Modelos
use App\Models\TransparencyDocument;

use Illuminate\Http\Request;

class TransparencyDocumentController extends Controller
{
    public function index()
    {
        $transparency_documents = TransparencyDocument::paginate(10);

        return view('transparency_documents.index')->with('transparency_documents', $transparency_documents);
    }

    public function create()
    {
        return view('transparency_documents.create');
    }

    public function store(Request $request)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        // Guardar datos en la base de datos
        $transparency_document = TransparencyDocument::create([
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
        $transparency_document = TransparencyDocument::find($id);

        return view('transparency_documents.show')->with('transparency_document', $transparency_document);
    }

    public function edit($id)
    {
        $transparency_document = TransparencyDocument::find($id);

        return view('transparency_documents.edit')->with('transparency_document', $transparency_document);
    }

    public function update(Request $request, $id)
    {
        //Validar
        $this -> validate($request, array(
            'name' => 'required|max:255',
        ));

        $transparency_document = TransparencyDocument::find($id);

        $transparency_document->update([
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
        $transparency_document = TransparencyDocument::find($id);
        $transparency_document->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}
