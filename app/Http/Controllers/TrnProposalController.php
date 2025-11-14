<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;

// Modelos
use App\Models\TrnProposal;

use Illuminate\Http\Request;

class TrnProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proposals = TrnProposal::orderBy('id', 'desc')->paginate(10);

        return view('trn_proposals.index')->with('proposals', $proposals);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trn_proposals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'document' => 'required|file|mimes:pdf,doc,docx,zip,png,jpeg,jpg|max:51200', // 50MB max
        ]);

        // Guardar archivo en S3
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $filename = 'convocatoria_' . Str::slug($request->title) . '_' . time() . '.' . $document->getClientOriginalExtension();
            $filepath = 'proposals/' . $filename;

            // Usar streaming para subir archivo a S3
            $stream = fopen($document->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            $s3_url = Storage::disk('s3')->url($filepath);

            // Guardar datos en la base de datos
            $proposal = TrnProposal::create([
                'title' => $request->title,
                'description' => $request->description,
                'filename' => $filename,
                'filepath' => $s3_url,
                'file_type' => $document->getClientOriginalExtension(),
                'filesize' => $document->getSize(),
                'in_index' => $request->has('in_index') ? true : false,
            ]);

            // Mensaje de session
            Session::flash('success', 'Convocatoria guardada correctamente.');

            // Enviar a vista
            return redirect()->route('trn_proposals.index');
        }

        Session::flash('error', 'Error al subir el archivo.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $proposal = TrnProposal::find($id);

        return view('trn_proposals.show')->with('proposal', $proposal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proposal = TrnProposal::find($id);

        return view('trn_proposals.edit')->with('proposal', $proposal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'document' => 'nullable|file|mimes:pdf,doc,docx,zip|max:51200', // 50MB max
        ]);

        $proposal = TrnProposal::find($id);

        // Si hay un nuevo archivo, eliminar el anterior de S3 y subir el nuevo
        if ($request->hasFile('document')) {
            // Eliminar archivo anterior de S3
            if ($proposal->filepath) {
                $oldPath = parse_url($proposal->filepath, PHP_URL_PATH);
                $oldPath = ltrim($oldPath, '/');
                if (Storage::disk('s3')->exists($oldPath)) {
                    Storage::disk('s3')->delete($oldPath);
                }
            }

            $document = $request->file('document');
            $filename = 'convocatoria_' . Str::slug($request->title) . '_' . time() . '.' . $document->getClientOriginalExtension();
            $filepath = 'proposals/' . $filename;

            // Usar streaming para subir archivo a S3
            $stream = fopen($document->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            $s3_url = Storage::disk('s3')->url($filepath);

            $proposal->update([
                'title' => $request->title,
                'description' => $request->description,
                'filename' => $filename,
                'filepath' => $s3_url,
                'file_type' => $document->getClientOriginalExtension(),
                'filesize' => $document->getSize(),
                'in_index' => $request->has('in_index') ? true : false,
            ]);
        } else {
            // Actualizar solo los campos sin archivo
            $proposal->update([
                'title' => $request->title,
                'description' => $request->description,
                'in_index' => $request->has('in_index') ? true : false,
            ]);
        }

        // Mensaje de session
        Session::flash('success', 'Convocatoria actualizada exitosamente.');

        // Enviar a vista
        return redirect()->route('trn_proposals.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $proposal = TrnProposal::find($id);

        // Eliminar archivo de S3
        if ($proposal->filepath) {
            $path = parse_url($proposal->filepath, PHP_URL_PATH);
            $path = ltrim($path, '/');
            if (Storage::disk('s3')->exists($path)) {
                Storage::disk('s3')->delete($path);
            }
        }

        // Eliminar registro
        $proposal->delete();

        Session::flash('success', 'Convocatoria eliminada exitosamente.');
        return redirect()->route('trn_proposals.index');
    }
}
