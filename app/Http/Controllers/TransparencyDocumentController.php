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
    /*
    public function index()
    {
        $transparency_documents = TransparencyDocument::paginate(10);

        return view('transparency_documents.index')->with('transparency_documents', $transparency_documents);
    }
    */

    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'obligation_id' => 'required|integer|exists:transparency_obligations,id',
            'name' => 'required|max:255',
            'year' => 'required|digits:4',
            'filename' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar',
        ]);

        // Subir archivo
        $file = $request->file('filename');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('files/documents'), $filename);

        // Guardar datos en la base de datos
        $transparency_document = TransparencyDocument::create([
            'obligation_id' => $request->obligation_id,
            'name' => $request->name,
            'description' => $request->description,
            'period' => $request->period,
            'year' => $request->year,
            'filename' => $filename,
            'file_extension' => $file->getClientOriginalExtension(),
            'uploaded_by' => Auth::id(),
        ]);

        // Mensaje de session
        Session::flash('success', 'Información guardada correctamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'obligation_id' => 'required|integer|exists:transparency_obligations,id',
            'name' => 'required|max:255',
            'year' => 'required|digits:4',
            'filename' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar',
        ]);

        $transparency_document = TransparencyDocument::find($id);

        // Subir archivo si existe
        if ($request->hasFile('filename')) {
            $file = $request->file('filename');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('files/documents'), $filename);

            // Eliminar el archivo anterior
            if (\File::exists(public_path('files/documents/' . $transparency_document->filename))) {
                \File::delete(public_path('files/documents/' . $transparency_document->filename));
            }

            $transparency_document->filename = $filename;
            $transparency_document->file_extension = $file->getClientOriginalExtension();
        }

        // Actualizar datos en la base de datos
        $transparency_document->update([
            'obligation_id' => $request->obligation_id,
            'name' => $request->name,
            'description' => $request->description,
            'period' => $request->period,
            'year' => $request->year,
            'uploaded_by' => Auth::id(),
        ]);

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function destroy($id)
    {
        $transparency_document = TransparencyDocument::find($id);

        // Eliminar el archivo del sistema de archivos
        if (\File::exists(public_path('files/documents/' . $transparency_document->filename))) {
            \File::delete(public_path('files/documents/' . $transparency_document->filename));
        }

        $transparency_document->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }
}