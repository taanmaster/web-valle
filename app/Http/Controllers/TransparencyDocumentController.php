<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;

// Modelos
use App\Models\TransparencyDocument;
use App\Models\TransparencyObligation;

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

        // Guardar archivo (método tradicional o streaming)
        if ($request->hasFile('filename')) {
            $file = $request->file('filename');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            
            /* Guardar en S3 usando streaming */
            $filepath = 'transparency/documents/' . $filename;
            
            // Usar streaming para archivos
            $stream = fopen($file->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
            
            // Guardar datos en la base de datos
            $transparency_document = TransparencyDocument::create([
                'obligation_id' => $request->obligation_id,
                'name' => $request->name,
                'description' => $request->description,
                'period' => $request->period,
                'year' => $request->year,
                'filename' => $filename,
                's3_asset_url' => Storage::disk('s3')->url($filepath),
                'filesize' => $file->getSize(),
                'file_extension' => $file->getClientOriginalExtension(),
                'uploaded_by' => Auth::id(),
            ]);
        }

        // Si es una petición AJAX (para subida directa), devolver JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Documento creado correctamente',
                'document' => $transparency_document,
                'id' => $transparency_document->id,
            ]);
        }

        // Mensaje de session para método tradicional
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

        $transparency_obligation = TransparencyObligation::find($id);

        return view('transparency_documents.edit')->with('transparency_document', $transparency_document)->with('transparency_obligation', $transparency_obligation);
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
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            
            /* Guardar en S3 usando streaming */
            $filepath = 'transparency/documents/' . $filename;
            
            // Usar streaming para archivos
            $stream = fopen($file->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            // Eliminar el archivo anterior de S3
            if ($transparency_document->filename && $transparency_document->filename !== 'empty') {
                $oldPath = 'transparency/documents/' . $transparency_document->filename;
                if (Storage::disk('s3')->exists($oldPath)) {
                    Storage::disk('s3')->delete($oldPath);
                }
            }

            $transparency_document->filename = $filename;
            $transparency_document->s3_asset_url = Storage::disk('s3')->url($filepath);
            $transparency_document->filesize = $file->getSize();
            $transparency_document->file_extension = $file->getClientOriginalExtension();
        }

        // Actualizar datos en la base de datos
        $transparency_document->update([
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

    public function deleteFile($id)
    {
        $transparency_document = TransparencyDocument::find($id);

        // Eliminar archivo de S3
        if ($transparency_document->filename && $transparency_document->filename !== 'empty') {
            $s3Path = 'transparency/documents/' . $transparency_document->filename;
            if (Storage::disk('s3')->exists($s3Path)) {
                Storage::disk('s3')->delete($s3Path);
            }
        }

        // Actualizar el campo filename a empty y limpiar URL de S3
        $transparency_document->filename = 'empty';
        $transparency_document->s3_asset_url = null;
        $transparency_document->save();

        Session::flash('success', 'Se eliminó el archivo de manera exitosa.');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $transparency_document = TransparencyDocument::find($id);

        // Eliminar el archivo de S3
        if ($transparency_document->filename && $transparency_document->filename !== 'empty') {
            $s3Path = 'transparency/documents/' . $transparency_document->filename;
            if (Storage::disk('s3')->exists($s3Path)) {
                Storage::disk('s3')->delete($s3Path);
            }
        }

        $transparency_document->delete();

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
            'filesize' => 'required|integer|max:104857600', // 100MB máximo
            'chunk_size' => 'required|integer',
            'obligation_id' => 'required|exists:transparency_obligations,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'period' => 'required|string',
            'year' => 'required|digits:4',
        ]);

        // Validar extensión de archivo
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar', 'jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($request->filename, PATHINFO_EXTENSION));
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            return response()->json([
                'success' => false,
                'error' => 'Tipo de archivo no permitido. Solo se permiten: ' . implode(', ', $allowedExtensions)
            ], 400);
        }

        $filename = time() . '_' . Str::slug($request->name) . '.' . $fileExtension;
        $filepath = 'transparency/documents/' . $filename;
        
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
            'document_data' => [
                'obligation_id' => $request->obligation_id,
                'name' => $request->name,
                'description' => $request->description,
                'period' => $request->period,
                'year' => $request->year,
            ]
        ];

        // Guardar en cache (1 hora)
        cache()->put('chunk_upload_transparency_document_' . $uploadSession['upload_id'], $uploadSession, 3600);

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

        $uploadSession = cache()->get('chunk_upload_transparency_document_' . $request->upload_id);
        
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
            cache()->put('chunk_upload_transparency_document_' . $request->upload_id, $uploadSession, 3600);

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
        ]);

        $uploadSession = cache()->get('chunk_upload_transparency_document_' . $request->upload_id);
        
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
            cache()->forget('chunk_upload_transparency_document_' . $request->upload_id);

            // Crear registro en base de datos
            $data = $uploadSession['document_data'];
            $transparency_document = TransparencyDocument::create([
                'obligation_id' => $data['obligation_id'],
                'name' => $data['name'],
                'description' => $data['description'],
                'period' => $data['period'],
                'year' => $data['year'],
                'filename' => $uploadSession['filename'],
                's3_asset_url' => Storage::disk('s3')->url($uploadSession['filepath']),
                'filesize' => $uploadSession['total_size'],
                'file_extension' => pathinfo($uploadSession['filename'], PATHINFO_EXTENSION),
                'uploaded_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Documento subido correctamente',
                'document_id' => $transparency_document->id,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al finalizar subida: ' . $e->getMessage()], 500);
        }
    }
}
