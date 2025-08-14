<?php

namespace App\Http\Controllers;

// Ayudantes
use Str;
use Auth;
use Session;
use Intervention\Image\Facades\Image as Image;

// Modelos
use App\Models\SareRequest;
use App\Models\SareRequestFile;
use App\Models\User;

use Illuminate\Http\Request;

class SareRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sare_requests = SareRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('front.citizen_profile.requests')->with('sare_requests', $sare_requests);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sare_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar
        $this->validate($request, [
            'request_num' => 'required|max:255',
            'request_date' => 'required|date',
            'catastral_num' => 'required|max:255',
            'request_type' => 'required|in:general,nuevo,renovacion,anuncio',
            'rfc_name' => 'required|max:255',
            'rfc_num' => 'required|max:255',
            'property_owner' => 'required|max:255',
            'office_phone' => 'required|max:255',
            'mobile_phone' => 'required|max:255',
            'email' => 'required|email|max:255',
            'legal_representative_name' => 'required|max:255',
            'legal_representative_father_last_name' => 'required|max:255',
            'legal_representative_mother_last_name' => 'required|max:255',
            'legal_representative_office_phone' => 'required|max:255',
            'legal_representative_mobile_phone' => 'required|max:255',
            'legal_representative_personal_phone' => 'required|max:255',
            'legal_representative_email' => 'required|email|max:255',
            'legal_representative_ownership_document' => 'required|in:Apoderado Especial,Apoderado General,Gestor de Trámite,Poder Notariado,Escritura Pública,Poder Simple',
            'establishment_legal_cause' => 'required|in:Proprietario,Arrendatario,Otro',
            'establishment_good_faith_clause' => 'required|in:Si,No,N/A',
            'establishment_address_street' => 'required|max:255',
            'establishment_address_number' => 'required|max:255',
            'establishment_address_neighborhood' => 'required|max:255',
            'establishment_address_municipality' => 'required|max:255',
            'establishment_address_state' => 'required|max:255',
            'establishment_address_postal_code' => 'required|max:255',
            'commercial_name' => 'required|max:255',
            'aprox_investment' => 'required|max:255',
            'jobs_to_generate' => 'required|integer|min:0',
        ]);

        // Guardar datos en la base de datos
        $sare_request = SareRequest::create([
            'user_id' => Auth::id(),
            'status' => $request->status ?? 'new',
            'request_type' => $request->request_type,
            'description' => $request->description,
            'request_num' => $request->request_num,
            'request_date' => $request->request_date,
            'catastral_num' => $request->catastral_num,
            'rfc_name' => $request->rfc_name,
            'rfc_num' => $request->rfc_num,
            'property_owner' => $request->property_owner,
            'office_phone' => $request->office_phone,
            'mobile_phone' => $request->mobile_phone,
            'email' => $request->email,
            'legal_representative_name' => $request->legal_representative_name,
            'legal_representative_father_last_name' => $request->legal_representative_father_last_name,
            'legal_representative_mother_last_name' => $request->legal_representative_mother_last_name,
            'legal_representative_office_phone' => $request->legal_representative_office_phone,
            'legal_representative_mobile_phone' => $request->legal_representative_mobile_phone,
            'legal_representative_personal_phone' => $request->legal_representative_personal_phone,
            'legal_representative_email' => $request->legal_representative_email,
            'legal_representative_ownership_document' => $request->legal_representative_ownership_document,
            'establishment_legal_cause' => $request->establishment_legal_cause,
            'establishment_legal_cause_addon' => $request->establishment_legal_cause_addon,
            'establishment_good_faith_clause' => $request->establishment_good_faith_clause,
            'establishment_address_street' => $request->establishment_address_street,
            'establishment_address_number' => $request->establishment_address_number,
            'establishment_address_neighborhood' => $request->establishment_address_neighborhood,
            'establishment_address_municipality' => $request->establishment_address_municipality,
            'establishment_address_state' => $request->establishment_address_state,
            'establishment_address_postal_code' => $request->establishment_address_postal_code,
            'establishment_use' => $request->establishment_use,
            'commercial_name' => $request->commercial_name,
            'aprox_investment' => $request->aprox_investment,
            'jobs_to_generate' => $request->jobs_to_generate,
            'is_location_in_operation' => $request->has('is_location_in_operation'),
            'operation_start_date' => $request->operation_start_date,
            'business_hours' => $request->business_hours,
            'zoning_front' => $request->zoning_front,
            'zoning_rear' => $request->zoning_rear,
            'zoning_left' => $request->zoning_left,
            'zoning_right' => $request->zoning_right,
        ]);

        // Mensaje de session
        Session::flash('success', 'Solicitud SARE guardada correctamente.');

        // Enviar a vista
        return redirect()->route('citizen.profile.requests');
    }

    /**
     * Display the specified resource.
     */
    public function show(SareRequest $sareRequest)
    {
        // Verificar que el usuario sea propietario de la solicitud o tenga permisos
        if ($sareRequest->user_id !== Auth::id() && !Auth::user()->can('view-all-sare-requests')) {
            abort(403, 'No tienes permisos para ver esta solicitud.');
        }

        // Cargar archivos relacionados
        $sareRequest->load('files');

        return view('sare_requests.show', compact('sareRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SareRequest $sareRequest)
    {
        // Verificar que el usuario sea propietario de la solicitud
        if ($sareRequest->user_id !== Auth::id()) {
            abort(403, 'No tienes permisos para editar esta solicitud.');
        }

        return view('sare_requests.edit')->with('sare_request', $sareRequest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SareRequest $sareRequest)
    {
        // Verificar que el usuario sea propietario de la solicitud
        if ($sareRequest->user_id !== Auth::id()) {
            abort(403, 'No tienes permisos para editar esta solicitud.');
        }

        // Validar
        $this->validate($request, [
            'request_num' => 'required|max:255',
            'request_date' => 'required|date',
            'catastral_num' => 'required|max:255',
            'request_type' => 'required|in:general,nuevo,renovacion,anuncio',
            'rfc_name' => 'required|max:255',
            'rfc_num' => 'required|max:255',
            'property_owner' => 'required|max:255',
            'office_phone' => 'required|max:255',
            'mobile_phone' => 'required|max:255',
            'email' => 'required|email|max:255',
            'commercial_name' => 'required|max:255',
            'aprox_investment' => 'required|max:255',
            'jobs_to_generate' => 'required|integer|min:0',
        ]);

        // Actualizar datos en la base de datos
        $sareRequest->update($request->all());

        // Mensaje de session
        Session::flash('success', 'Solicitud SARE actualizada exitosamente.');

        // Enviar a vista
        return redirect()->route('citizen.profile.requests');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SareRequest $sareRequest)
    {
        // Verificar que el usuario sea propietario de la solicitud o tenga permisos
        if ($sareRequest->user_id !== Auth::id() && !Auth::user()->can('delete-sare-requests')) {
            abort(403, 'No tienes permisos para eliminar esta solicitud.');
        }

        // Eliminar archivos asociados
        $sareRequest->files->each(function ($file) {
            // Eliminar el archivo del sistema de archivos
            if (\File::exists(public_path('files/sare_requests/' . $file->filename))) {
                \File::delete(public_path('files/sare_requests/' . $file->filename));
            }
            $file->delete();
        });

        // Eliminar la solicitud
        $sareRequest->delete();

        Session::flash('success', 'Se eliminó la solicitud de manera exitosa.');
        return redirect()->back();
    }

    /**
     * Upload files via dropzone
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::random(8) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $location = public_path('files/sare_requests/' . $filename);

            // Crear directorio si no existe
            if (!file_exists(public_path('files/sare_requests'))) {
                mkdir(public_path('files/sare_requests'), 0755, true);
            }

            $file->move(public_path('files/sare_requests'), $filename);

            // Guardar en base de datos si hay un sare_request_id
            if ($request->has('sare_request_id')) {
                SareRequestFile::create([
                    'sare_request_id' => $request->sare_request_id,
                    'user_id' => Auth::id(),
                    'name' => $file->getClientOriginalName(),
                    'slug' => Str::slug($file->getClientOriginalName()),
                    'filename' => $filename,
                    'file_extension' => $file->getClientOriginalExtension(),
                ]);
            }

            return response()->json(['success' => 'Archivo subido correctamente']);
        }

        return response()->json(['error' => 'No se pudo subir el archivo'], 400);
    }

    /**
     * Fetch uploaded files
     */
    public function fetch($sareRequestId)
    {
        $files = SareRequestFile::where('sare_request_id', $sareRequestId)->get();
        
        $output = '';
        foreach ($files as $file) {
            $output .= '
            <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-2"></i>
                    <div>
                        <h6 class="mb-0">' . $file->name . '</h6>
                        <small class="text-muted">' . $file->formatted_size . '</small>
                    </div>
                </div>
                <div>
                    <a href="' . $file->url . '" target="_blank" class="btn btn-sm btn-outline-primary me-1">
                        <i class="bx bx-download"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger remove_file" id="' . $file->filename . '">
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
            </div>';
        }

        return $output;
    }

    /**
     * Delete uploaded file
     */
    public function delete(Request $request, $sareRequestId)
    {
        $filename = $request->name;
        $file = SareRequestFile::where('sare_request_id', $sareRequestId)
                               ->where('filename', $filename)
                               ->first();

        if ($file) {
            // Eliminar archivo del sistema de archivos
            if (\File::exists(public_path('files/sare_requests/' . $filename))) {
                \File::delete(public_path('files/sare_requests/' . $filename));
            }

            // Eliminar registro de la base de datos
            $file->delete();

            return response()->json(['success' => 'Archivo eliminado correctamente']);
        }

        return response()->json(['error' => 'Archivo no encontrado'], 404);
    }

    /**
     * Initialize chunk upload for large files
     */
    public function initChunkUpload(Request $request)
    {
        $filename = $request->filename;
        $filesize = $request->filesize;
        $chunkSize = $request->chunk_size;
        
        $totalChunks = ceil($filesize / $chunkSize);
        $uploadId = Str::random(32);
        
        // Crear directorio temporal para chunks
        $tempDir = public_path('temp/chunks/' . $uploadId);
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }
        
        return response()->json([
            'success' => true,
            'upload_id' => $uploadId,
            'total_chunks' => $totalChunks
        ]);
    }

    /**
     * Upload chunk for large files
     */
    public function uploadChunk(Request $request)
    {
        $uploadId = $request->upload_id;
        $chunkNumber = $request->chunk_number;
        $chunk = $request->file('chunk');
        
        $tempDir = public_path('temp/chunks/' . $uploadId);
        $chunkPath = $tempDir . '/chunk_' . $chunkNumber;
        
        $chunk->move($tempDir, 'chunk_' . $chunkNumber);
        
        return response()->json([
            'success' => true,
            'progress' => 100 // Para este chunk específico
        ]);
    }

    /**
     * Finalize chunk upload for large files
     */
    public function finalizeChunkUpload(Request $request)
    {
        $uploadId = $request->upload_id;
        $tempDir = public_path('temp/chunks/' . $uploadId);
        
        // Verificar que todos los chunks estén presentes
        $chunks = glob($tempDir . '/chunk_*');
        sort($chunks, SORT_NATURAL);
        
        // Combinar chunks
        $filename = Str::random(8) . '_' . time() . '.bin';
        $finalPath = public_path('files/sare_requests/' . $filename);
        
        // Crear directorio si no existe
        if (!file_exists(public_path('files/sare_requests'))) {
            mkdir(public_path('files/sare_requests'), 0755, true);
        }
        
        $output = fopen($finalPath, 'wb');
        
        foreach ($chunks as $chunkFile) {
            $input = fopen($chunkFile, 'rb');
            stream_copy_to_stream($input, $output);
            fclose($input);
        }
        
        fclose($output);
        
        // Limpiar chunks temporales
        array_map('unlink', $chunks);
        rmdir($tempDir);
        
        return response()->json([
            'success' => true,
            'filename' => $filename
        ]);
    }
}
