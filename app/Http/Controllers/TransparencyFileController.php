<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;

// Modelos
use App\Models\TransparencyFile;
use App\Models\TransparencyDependency;

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

    function uploadFile(Request $request, $id)
    {
        $dependency = TransparencyDependency::find($id);

        // Guardar datos en la base de datos
        $var_file = new TransparencyFile;
        $var_file->dependency_id = $dependency->id;

        $file = $request->file('file');
        $filename = Str::slug($dependency->name) . '_' . Str::random(8) . '_file' . '.' . $file->getClientOriginalExtension();

        /* Guardar en S3 usando streaming */
        $filepath = 'transparency/files/' . $filename;

        // Usar streaming para archivos
        $stream = fopen($file->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        $var_file->s3_asset_url = Storage::disk('s3')->url($filepath);
        $var_file->name = $filename;
        $var_file->filename = $filename;
        $var_file->file_extension = $file->getClientOriginalExtension();
        $var_file->filesize = $file->getSize();
        $var_file->uploaded_by = Auth::user()->id;

        $var_file->save();

        return response()->json(['success' => $filename]);
    }

    function fetchFile($id)
    {
        $dependency = TransparencyDependency::find($id);

        $output = '<tbody>';
        foreach($dependency->files as $file)
        {
            $icon = 'fa-file';
            $badge = '';

            // Condicional para determinar qué ruta usar
            if ($file->s3_asset_url !== null) {
                $publicPath = $file->s3_asset_url; // Usar ruta de Amazon AWS
            } else {
                $publicPath = url('files/transparency/' . $file->filename); // Usar ruta local tradicional
            }

            switch ($file->file_extension) {
                case 'pdf':
                    $icon = 'fa-file-pdf';
                    $badge = 'PDF';
                    break;
                case 'doc':
                case 'docx':
                    $icon = 'fa-file-word';
                    $badge = 'Word';
                    break;
                case 'xls':
                case 'xlsx':
                    $icon = 'fa-file-excel';
                    $badge = 'Excel';
                    break;
                case 'ppt':
                case 'pptx':
                    $icon = 'fa-file-powerpoint';
                    $badge = 'PowerPoint';
                    break;
                case 'txt':
                    $icon = 'fa-file-alt';
                    $badge = 'Texto';
                    break;
                case 'zip':
                case 'rar':
                    $icon = 'fa-file-archive';
                    $badge = 'Archivo';
                    break;
                default:
                    $icon = 'fa-file';
                    $badge = 'Archivo';
                    break;
            }

            $fileSizeFormatted = $file->filesize ? $this->formatFileSize($file->filesize) : 'N/A';

            $output .= '
            <tr>
                <td>'.$file->id.'</td>
                <td>'.$file->name.'</td>
                <td>'.$file->filename.'</td>
                <td>'.$file->obligation->name. '</td>
                <td><span class="badge bg-primary">' . $badge . '</span></td>
                <td>'.$file->created_at. '</td>
                <td>
                    <button type="button" class="btn btn-outline-primary mt-2" onclick="copyToClipboard(\'filePath' . $file->id . '\')">Copiar Ruta</button>
                    <button type="button" class="btn btn-link remove_file mt-2" id="' . $file->filename . '">Eliminar</button>
                </td>
            </tr>
            ';
        }
        $output .= '</tbody>';

        echo $output;
    }

    function deleteFile(Request $request)
    {
        $file = TransparencyFile::where('filename', $request->name)->first();

        if ($file) {
            // Eliminar el archivo de S3
            $s3Path = 'transparency/files/' . $file->filename;
            if (Storage::disk('s3')->exists($s3Path)) {
                Storage::disk('s3')->delete($s3Path);
            }

            // Eliminar el archivo de la base de datos
            $file->delete();

            return response()->json(['success' => 'Archivo eliminado correctamente.']);
        }

        return response()->json(['error' => 'Archivo no encontrado.'], 404);
    }

    /**
     * Formatear tamaño de archivo
     */
    private function formatFileSize($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
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
            'dependency_id' => 'required|exists:transparency_dependencies,id',
        ]);

        // Validar extensión de archivo
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar', 'png', 'jpg', 'jpeg', 'gif', 'bmp'];
        $fileExtension = strtolower(pathinfo($request->filename, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            return response()->json([
                'success' => false,
                'error' => 'Tipo de archivo no permitido. Solo se permiten: ' . implode(', ', $allowedExtensions)
            ], 400);
        }

        $dependency = TransparencyDependency::find($request->dependency_id);
        $filename = Str::slug($dependency->name) . '_' . Str::random(8) . '_file.' . $fileExtension;
        $filepath = 'transparency/files/' . $filename;

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
            'file_data' => [
                'dependency_id' => $request->dependency_id,
                'original_filename' => $request->filename,
            ]
        ];

        // Guardar en cache (1 hora)
        cache()->put('chunk_upload_transparency_file_' . $uploadSession['upload_id'], $uploadSession, 3600);

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

        $uploadSession = cache()->get('chunk_upload_transparency_file_' . $request->upload_id);

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
            cache()->put('chunk_upload_transparency_file_' . $request->upload_id, $uploadSession, 3600);

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

        $uploadSession = cache()->get('chunk_upload_transparency_file_' . $request->upload_id);

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
            cache()->forget('chunk_upload_transparency_file_' . $request->upload_id);

            // Crear registro en base de datos
            $data = $uploadSession['file_data'];
            $transparency_file = TransparencyFile::create([
                'dependency_id' => $data['dependency_id'],
                'name' => $uploadSession['filename'],
                'filename' => $uploadSession['filename'],
                's3_asset_url' => Storage::disk('s3')->url($uploadSession['filepath']),
                'filesize' => $uploadSession['total_size'],
                'file_extension' => pathinfo($uploadSession['filename'], PATHINFO_EXTENSION),
                'uploaded_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Archivo subido correctamente',
                'file_id' => $transparency_file->id,
                'filename' => $transparency_file->filename,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al finalizar subida: ' . $e->getMessage()], 500);
        }
    }
}
