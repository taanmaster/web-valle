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

class GazetteFileController extends Controller
{
    /* Vinculado a Gazette */
    /*
    * Generalmente las gacetas son de 1 solo documento
    * pero existen casos donde se adjuntas múltiples.
    */

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
        
        /*
        $location = public_path('files/gazettes/');
        $document->move($location, $filename);
        */

        $filepath = 'gazettes/' . $filename;
        $file->filename = $filename;
        $file->file_extension = $document->getClientOriginalExtension();
        $file->filesize = $document->getSize();

        /* Guardar en S3 */
        Storage::disk('s3')->put($filepath, file_get_contents($document));
        $file->s3_asset_url = Storage::disk('s3')->url($filepath);

        $file->uploaded_by = Auth::user()->id;
        $file->save();

        // Mensaje de session
        Session::flash('success', 'Información editada exitosamente.');

        // Enviar a vista
        return redirect()->back();
    }

    public function initChunkUpload(Request $request)
    {
        $this->validate($request, [
            'gazette_id' => 'required|exists:gazettes,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'filename' => 'required|string',
            'filesize' => 'required|integer|min:1|max:524288000',
            'chunk_size' => 'required|integer|min:1',
        ]);

        $gazette = Gazette::findOrFail($request->gazette_id);
        $extension = pathinfo($request->filename, PATHINFO_EXTENSION);
        $filename = 'gaceta_' . Str::slug($request->name) . '_' . $gazette->document_number . '.' . $extension;
        $uploadId = uniqid();

        cache()->put('chunk_upload_gazette_file_' . $uploadId, [
            'filepath' => 'gazettes/' . $filename,
            'filename' => $filename,
            'total_size' => $request->filesize,
            'chunk_size' => $request->chunk_size,
            'total_chunks' => (int) ceil($request->filesize / $request->chunk_size),
            'uploaded_chunks' => [],
            'file_data' => [
                'gazette_id' => $gazette->id,
                'name' => $request->name,
                'description' => $request->description,
            ],
        ], 3600);

        return response()->json([
            'success' => true,
            'upload_id' => $uploadId,
            'total_chunks' => (int) ceil($request->filesize / $request->chunk_size),
        ]);
    }

    public function uploadChunk(Request $request)
    {
        $this->validate($request, [
            'upload_id' => 'required|string',
            'chunk_number' => 'required|integer|min:0',
            'chunk' => 'required|file',
        ]);

        $cacheKey = 'chunk_upload_gazette_file_' . $request->upload_id;
        $uploadSession = cache()->get($cacheKey);

        if (!$uploadSession || $request->chunk_number >= $uploadSession['total_chunks']) {
            return response()->json(['error' => 'Sesión o fragmento de subida inválido'], 400);
        }

        try {
            $tempDir = storage_path('app/temp/chunks/' . $request->upload_id);
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $request->file('chunk')->move($tempDir, 'chunk_' . $request->chunk_number);
            $uploadSession['uploaded_chunks'][$request->chunk_number] = true;
            cache()->put($cacheKey, $uploadSession, 3600);

            return response()->json([
                'success' => true,
                'progress' => round(count($uploadSession['uploaded_chunks']) / $uploadSession['total_chunks'] * 100, 2),
            ]);
        } catch (\Exception $exception) {
            report($exception);

            return response()->json(['error' => 'No se pudo guardar el fragmento'], 500);
        }
    }

    public function finalizeChunkUpload(Request $request)
    {
        $this->validate($request, [
            'upload_id' => 'required|string',
        ]);

        $cacheKey = 'chunk_upload_gazette_file_' . $request->upload_id;
        $uploadSession = cache()->get($cacheKey);

        if (!$uploadSession) {
            return response()->json(['error' => 'Sesión de subida no encontrada'], 400);
        }

        try {
            $tempDir = storage_path('app/temp/chunks/' . $request->upload_id);
            $finalFile = storage_path('app/temp/' . $uploadSession['filename']);

            if (!file_exists(dirname($finalFile))) {
                mkdir(dirname($finalFile), 0755, true);
            }

            $finalFileHandle = fopen($finalFile, 'wb');
            for ($chunkNumber = 0; $chunkNumber < $uploadSession['total_chunks']; $chunkNumber++) {
                $chunkPath = $tempDir . '/chunk_' . $chunkNumber;
                if (!file_exists($chunkPath)) {
                    throw new \RuntimeException('Falta un fragmento de la subida.');
                }

                $chunkHandle = fopen($chunkPath, 'rb');
                stream_copy_to_stream($chunkHandle, $finalFileHandle);
                fclose($chunkHandle);
                unlink($chunkPath);
            }
            fclose($finalFileHandle);

            $stream = fopen($finalFile, 'r');
            $stored = Storage::disk('s3')->put($uploadSession['filepath'], $stream);
            fclose($stream);

            if (!$stored) {
                throw new \RuntimeException('No se pudo guardar el archivo en el almacenamiento.');
            }

            unlink($finalFile);
            rmdir($tempDir);
            cache()->forget($cacheKey);

            $file = GazetteFile::create([
                'gazette_id' => $uploadSession['file_data']['gazette_id'],
                'name' => $uploadSession['file_data']['name'],
                'slug' => Str::slug('gaceta_' . $uploadSession['file_data']['name'] . '_' . $uploadSession['filename']),
                'description' => $uploadSession['file_data']['description'],
                'filename' => $uploadSession['filename'],
                'file_extension' => pathinfo($uploadSession['filename'], PATHINFO_EXTENSION),
                'filesize' => $uploadSession['total_size'],
                's3_asset_url' => Storage::disk('s3')->url($uploadSession['filepath']),
                'uploaded_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Archivo subido correctamente',
                'file_id' => $file->id,
            ]);
        } catch (\Exception $exception) {
            report($exception);

            return response()->json(['error' => 'No se pudo finalizar la subida'], 500);
        }
    }

    public function destroy($id)
    {
        $file = GazetteFile::findOrFail($id);

        // Eliminar archivo de S3
        $filepath = 'gazettes/' . $file->filename;
        Storage::disk('s3')->delete($filepath);
        
        $file->delete();

        Session::flash('exito', 'El archivo ha sido borrado exitosamente.');

        return redirect()->back();
    }
}
