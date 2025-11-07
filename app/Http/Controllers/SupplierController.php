<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:supplier']);
    }

    /**
     * Muestra el listado de altas del proveedor
     */
    public function index(Request $request)
    {
        $query = Supplier::where('user_id', Auth::id())
            ->with('files')
            ->orderBy('created_at', 'desc');

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por tipo de persona
        if ($request->filled('person_type')) {
            $query->where('person_type', $request->person_type);
        }

        // Filtro por nombre de empresa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('legal_name', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate(10);

        return view('front.user_profiles.supplier.create', compact('suppliers'));
    }

    /**
     * Muestra el formulario para crear una nueva alta
     */
    public function create()
    {
        return view('front.user_profiles.supplier.create');
    }

    /**
     * Inicia el proceso de alta (crea registro vacío con folio)
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'person_type' => 'required|in:fisica,moral'
        ]);

        $supplier = Supplier::create([
            'user_id' => Auth::id(),
            'person_type' => $request->person_type,
            'status' => 'solicitud',
            'email' => Auth::user()->email,
        ]);

        Session::flash('success', 'Se ha iniciado el proceso de alta con folio: ' . $supplier->registration_number);

        return redirect()->route('supplier.alta.form', $supplier->id);
    }

    /**
     * Muestra el formulario para editar/llenar los datos del alta
     */
    public function showForm($id)
    {
        $supplier = Supplier::where('user_id', Auth::id())
            ->findOrFail($id);

        $requiredDocuments = $supplier->getRequiredDocuments();

        return view('front.user_profiles.supplier.create_form', compact('supplier', 'requiredDocuments'));
    }

    /**
     * Almacena o actualiza los datos del alta
     */
    public function store(Request $request, $id)
    {
        $supplier = Supplier::where('user_id', Auth::id())
            ->findOrFail($id);

        // Validación dinámica según tipo de persona
        $rules = $this->getValidationRules($supplier->person_type);
        $request->validate($rules);

        // Actualizar datos
        $supplier->update($request->all());

        Session::flash('success', 'Los datos del alta se guardaron correctamente.');

        return redirect()->route('supplier.alta.form', $supplier->id);
    }

    /**
     * Sube un archivo al alta
     */
    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'document_slug' => 'required|string',
            'document_name' => 'required|string',
        ]);

        $supplier = Supplier::where('user_id', Auth::id())
            ->findOrFail($id);

        if ($request->hasFile('file')) {
            $document = $request->file('file');
            $filename = time() . '_' . $supplier->registration_number . '_' . $request->document_slug . '.' . $document->getClientOriginalExtension();
            $filepath = 'suppliers/' . $supplier->id . '/' . $filename;

            // Guardar en S3
            Storage::disk('s3')->put($filepath, file_get_contents($document));

            SupplierFile::create([
                'supplier_id' => $supplier->id,
                'filename' => $filename,
                'filepath' => $filepath,
                'file_type' => $request->document_slug,
                'status' => 'pendiente',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Archivo subido correctamente',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al subir el archivo',
        ], 400);
    }

    /**
     * Elimina un archivo del alta
     */
    public function deleteFile($id, $fileId)
    {
        $supplier = Supplier::where('user_id', Auth::id())
            ->findOrFail($id);

        $file = SupplierFile::where('supplier_id', $supplier->id)
            ->findOrFail($fileId);

        // Eliminar archivo de S3
        if ($file->filepath) {
            Storage::disk('s3')->delete($file->filepath);
        }

        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'Archivo eliminado correctamente',
        ]);
    }

    /**
     * Muestra un alta específica
     */
    public function show($id)
    {
        $supplier = Supplier::where('user_id', Auth::id())
            ->with('files')
            ->findOrFail($id);

        $requiredDocuments = $supplier->getRequiredDocuments();

        return view('front.user_profiles.supplier.show', compact('supplier', 'requiredDocuments'));
    }

    /**
     * Elimina una alta (soft delete)
     */
    public function destroy($id)
    {
        $supplier = Supplier::where('user_id', Auth::id())
            ->findOrFail($id);

        $supplier->delete();

        Session::flash('success', 'El alta se eliminó correctamente.');

        return redirect()->route('supplier.alta.index');
    }

    /**
     * Obtiene las reglas de validación según el tipo de persona
     */
    private function getValidationRules($personType)
    {
        $commonRules = [
            'rfc' => 'nullable|string|max:13',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'mobile_phone' => 'nullable|string|max:20',
            'nextel_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ];

        if ($personType === 'fisica') {
            return array_merge($commonRules, [
                'owner_name' => 'required|string|max:255',
                'business_name' => 'nullable|string|max:255',
                'activities_start_date' => 'nullable|date',
                'equity_capital' => 'nullable|numeric',
                'curp' => 'nullable|string|max:18',
                'chamber_registration' => 'nullable|string|max:255',
                'business_line' => 'nullable|string|max:255',
            ]);
        } else {
            return array_merge($commonRules, [
                'legal_name' => 'required|string|max:255',
                'partners_names' => 'nullable|string',
                'incorporation_date' => 'nullable|date',
                'share_capital' => 'nullable|numeric',
                'legal_representative' => 'nullable|string|max:255',
                'legal_representative_curp' => 'nullable|string|max:18',
                'shareholders_curp' => 'nullable|string',
                'deed_number' => 'nullable|string|max:255',
                'notary_name' => 'nullable|string|max:255',
                'predominant_activity' => 'nullable|string|max:255',
            ]);
        }
    }
}
