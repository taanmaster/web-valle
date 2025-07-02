<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;

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

        // Guardar archivo (método tradicional)
        if ($request->hasFile('document')) {
            // Guardar datos en la base de datos
            $file = new GazetteFile;
            $file->gazette_id = $gazette->id;
            $file->name = $request->name;
            $file->slug = Str::slug('gaceta_' .  $request->name . '_' . $request->document_number);
            $file->description = $request->description;

            $document = $request->file('document');
            $filename = 'gaceta_' .  $request->name . '_' . $request->document_number . '.' . $document->getClientOriginalExtension();

            /* Guardar en S3 usando streaming para archivos */
            $filepath = 'gazettes/' . $filename;
            
            // Usar streaming para archivos
            $stream = fopen($document->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
            
            $file->s3_asset_url = Storage::disk('s3')->url($filepath);

            $file->filesize = $document->getSize();
            $file->filename = $filename;
            $file->file_extension = $document->getClientOriginalExtension();
            $file->uploaded_by = Auth::user()->id;

            $file->save();
        }

        // Si es una petición AJAX (para subida directa), devolver JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Gaceta creada correctamente',
                'gazette' => $gazette,
                'id' => $gazette->id,
            ]);
        }

        // Mensaje de session para método tradicional
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
        
        // Eliminar archivos de S3 y registros de archivos relacionados
        if ($gazette->files()->exists()) {
            foreach ($gazette->files as $file) {
                // Construir la ruta del archivo usando el mismo patrón que en store()
                if ($file->filename) {
                    $s3Path = 'gazettes/' . $file->filename;
                    
                    // Eliminar archivo de S3
                    if (Storage::disk('s3')->exists($s3Path)) {
                        Storage::disk('s3')->delete($s3Path);
                    }
                }
                
                // Eliminar registro del archivo de la base de datos
                $file->delete();
            }
        }
        
        // Eliminar la gaceta
        $gazette->delete();

        Session::flash('success', 'Se eliminó la información de manera exitosa.');
        return redirect()->back();
    }

    /**
     * Iniciar subida por chunks
     */
    public function initChunkUpload(Request $request)
    {
        $this->validate($request, [
            'filename' => 'required|string',
            'filesize' => 'required|integer',
            'chunk_size' => 'required|integer',
            'gazette_name' => 'required|string',
            'document_number' => 'required|string',
        ]);

        $filename = 'gaceta_' . Str::slug($request->gazette_name) . '_' . $request->document_number . '.' . pathinfo($request->filename, PATHINFO_EXTENSION);
        $filepath = 'gazettes/' . $filename;
        
        // Crear registro temporal para tracking
        $uploadSession = [
            'upload_id' => uniqid(),
            'filepath' => $filepath,
            'filename' => $filename,
            'total_size' => $request->filesize,
            'chunk_size' => $request->chunk_size,
            'total_chunks' => ceil($request->filesize / $request->chunk_size),
            'uploaded_chunks' => [],
            'created_at' => now(),
        ];

        // Guardar en cache (1 hora)
        cache()->put('chunk_upload_' . $uploadSession['upload_id'], $uploadSession, 3600);

        return response()->json([
            'success' => true,
            'upload_id' => $uploadSession['upload_id'],
            'total_chunks' => $uploadSession['total_chunks'],
            'chunk_size' => $uploadSession['chunk_size'],
        ]);
    }

    /**
     * Subir chunk individual
     */
    public function uploadChunk(Request $request)
    {
        $this->validate($request, [
            'upload_id' => 'required|string',
            'chunk_number' => 'required|integer',
            'chunk' => 'required|file',
        ]);

        $uploadSession = cache()->get('chunk_upload_' . $request->upload_id);
        
        if (!$uploadSession) {
            return response()->json(['error' => 'Sesión de subida no encontrada'], 400);
        }

        try {
            // Crear directorio temporal para chunks
            $tempDir = storage_path('app/temp/chunks/' . $request->upload_id);
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Guardar chunk temporalmente
            $chunkPath = $tempDir . '/chunk_' . $request->chunk_number;
            $request->file('chunk')->move($tempDir, 'chunk_' . $request->chunk_number);

            // Actualizar progreso
            $uploadSession['uploaded_chunks'][] = $request->chunk_number;
            cache()->put('chunk_upload_' . $request->upload_id, $uploadSession, 3600);

            $progress = count($uploadSession['uploaded_chunks']) / $uploadSession['total_chunks'] * 100;

            return response()->json([
                'success' => true,
                'progress' => round($progress, 2),
                'uploaded_chunks' => count($uploadSession['uploaded_chunks']),
                'total_chunks' => $uploadSession['total_chunks'],
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al subir chunk: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Finalizar subida - combinar chunks y subir a S3
     */
    public function finalizeChunkUpload(Request $request)
    {
        $this->validate($request, [
            'upload_id' => 'required|string',
            'gazette_id' => 'required|exists:gazettes,id',
        ]);

        $uploadSession = cache()->get('chunk_upload_' . $request->upload_id);
        
        if (!$uploadSession) {
            return response()->json(['error' => 'Sesión de subida no encontrada'], 400);
        }

        try {
            $tempDir = storage_path('app/temp/chunks/' . $request->upload_id);
            $finalFile = storage_path('app/temp/' . $uploadSession['filename']);

            // Crear directorio temp si no existe
            $tempDirectory = dirname($finalFile);
            if (!file_exists($tempDirectory)) {
                mkdir($tempDirectory, 0755, true);
            }

            // Combinar chunks en orden
            $finalFileHandle = fopen($finalFile, 'wb');
            
            for ($i = 0; $i < $uploadSession['total_chunks']; $i++) {
                $chunkPath = $tempDir . '/chunk_' . $i;
                if (file_exists($chunkPath)) {
                    $chunkHandle = fopen($chunkPath, 'rb');
                    stream_copy_to_stream($chunkHandle, $finalFileHandle);
                    fclose($chunkHandle);
                    unlink($chunkPath); // Eliminar chunk
                }
            }
            fclose($finalFileHandle);

            // Subir archivo completo a S3 usando streaming
            $stream = fopen($finalFile, 'r');
            Storage::disk('s3')->put($uploadSession['filepath'], $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            // Limpiar archivos temporales
            unlink($finalFile);
            if (is_dir($tempDir)) {
                rmdir($tempDir);
            }
            cache()->forget('chunk_upload_' . $request->upload_id);

            // Crear registro en base de datos
            $gazette = Gazette::find($request->gazette_id);
            $file = new GazetteFile;
            $file->gazette_id = $gazette->id;
            $file->name = $gazette->name;
            $file->slug = Str::slug('gaceta_' . $gazette->name . '_' . $gazette->document_number);
            $file->description = $gazette->description;
            $file->s3_asset_url = Storage::disk('s3')->url($uploadSession['filepath']);
            $file->filesize = $uploadSession['total_size'];
            $file->filename = $uploadSession['filename'];
            $file->file_extension = pathinfo($uploadSession['filename'], PATHINFO_EXTENSION);
            $file->uploaded_by = Auth::user()->id;
            $file->save();

            return response()->json([
                'success' => true,
                'message' => 'Archivo subido correctamente',
                'file_id' => $file->id,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al finalizar subida: ' . $e->getMessage()], 500);
        }
    }
}
