<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;

// Modelos
use App\Models\DIFSocioEconomicTestFile as TestFile;

use Illuminate\Http\Request;

class DIFSocioEconomicTestFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = TestFile::orderBy('created_at', 'desc')->paginate(20);

        return view('dif.socio_economic_test_files.index')->with('files', $files);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dif.socio_economic_test_files.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'socio_economic_test_id' => 'required|integer|exists:d_i_f_socio_economic_tests,id',
            'file' => 'required|file',
            'name' => 'nullable|string|max:255',
        ]);

        $test_file = new TestFile();
        $test_file->user_id = Auth::user() ? Auth::user()->id : null;
        $test_file->socio_economic_test_id = $request->socio_economic_test_id;
        $test_file->name = $request->name ?: null;
        $test_file->slug = $test_file->name ? Str::slug($test_file->name) : null;

        $uploaded = $request->file('file');
        $originalName = $uploaded->getClientOriginalName();
        $extension = $uploaded->getClientOriginalExtension();
        $filesize = $uploaded->getSize();

        $filename = 'socio_test_' . ($test_file->name ? Str::slug($test_file->name) : uniqid()) . '.' . $extension;
        $filepath = 'socio_economic_tests/' . $filename;

        // Subir a S3 por streaming
        $stream = fopen($uploaded->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        $test_file->filename = $filename;
        $test_file->file_extension = $extension;
        $test_file->file_name = $originalName;
        $test_file->file_size = $filesize;
        $test_file->file_type = $uploaded->getMimeType();
        $test_file->s3_asset_url = Storage::disk('s3')->url($filepath);

        $test_file->save();

        // Response
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'file' => $test_file]);
        }

        Session::flash('success', 'Archivo guardado correctamente.');

        return redirect()->route('dif.socio_economic_test_files.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $test_file = TestFile::findOrFail($id);

        return view('dif.socio_economic_test_files.show')->with('file', $test_file);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $test_file = TestFile::findOrFail($id);

        return view('dif.socio_economic_test_files.edit')->with('file', $test_file);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $test_file = TestFile::findOrFail($id);
        
        $this->validate($request, [
            'name' => 'nullable|string|max:255',
            'file' => 'nullable|file',
        ]);

        $test_file->name = $request->name ?: $test_file->name;
        $test_file->slug = $test_file->name ? Str::slug($test_file->name) : $test_file->slug;

        // Si viene un nuevo archivo, reemplazar en S3
        if ($request->hasFile('file')) {
            // Eliminar anterior
            if ($test_file->filename) {
                $oldPath = 'socio_economic_tests/' . $test_file->filename;
                if (Storage::disk('s3')->exists($oldPath)) {
                    Storage::disk('s3')->delete($oldPath);
                }
            }

            $uploaded = $request->file('file');
            $originalName = $uploaded->getClientOriginalName();
            $extension = $uploaded->getClientOriginalExtension();
            $filesize = $uploaded->getSize();

            $filename = 'socio_economic_tests_' . ($test_file->name ? Str::slug($test_file->name) : uniqid()) . '.' . $extension;
            $filepath = 'socio_economic_tests/' . $filename;

            $stream = fopen($uploaded->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            $test_file->filename = $filename;
            $test_file->file_extension = $extension;
            $test_file->file_name = $originalName;
            $test_file->file_size = $filesize;
            $test_file->file_type = $uploaded->getMimeType();
            $test_file->s3_asset_url = Storage::disk('s3')->url($filepath);
        }

        $test_file->save();

        Session::flash('success', 'Archivo actualizado correctamente.');
        return redirect()->route('dif.socio_economic_test_files.show', $test_file->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $test_file = TestFile::findOrFail($id);

        // Eliminar archivo de S3
        if ($test_file->filename) {
            $path = 'socio_economic_tests/' . $test_file->filename;
            if (Storage::disk('s3')->exists($path)) {
                Storage::disk('s3')->delete($path);
            }
        }

        $test_file->delete();

        // Response
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Archivo eliminado correctamente.']);
        }

        Session::flash('success', 'Archivo eliminado correctamente.');
        return redirect()->route('dif.socio_economic_test_files.index');
    }
}
