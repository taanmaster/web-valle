<?php

namespace App\Livewire\Acquisitions\Inventory;

use Livewire\Component;

// Ayudantes
use PDF;
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

//
use App\Models\AcquisitionMaterial;
use App\Models\AcquisitionInventoryMovement;
use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class Movement extends Component
{
    use WithFileUploads;

    public $material;
    public $movement;
    public $supplier;

    //Modos: 0 crear, 1 show
    public $mode = 0;

    public $type = '';
    public $quantity = '';

    public $description = '';
    public $description_exit = '';
    public $reception_file = '';
    public $validation = '';
    public $request_file = '';
    public $approval_file = '';
    public $destiny = '';
    public $responsable = '';

    //Material seleccionado
    public $materialId = '';


    //Proveedor
    public $newSupplier = false;

    /*Campos*/
    public $user_type = 'supplier';

    public $name;
    public $person_type = '';
    public $company_name = '';
    public $email;
    public $password;
    public $password_confirmation;
    public $padron_status = '';

    public $selectedSupplier = '';
    public $supplier_id = '';
    public $supplier_name = '';
    public $supplier_num = '';
    public $supplier_type = '';

    public $searchSupplier = '';

    public $materials = [];

    public function mount()
    {
        if ($this->material != null) {
            $this->fetchMaterial();
        }

        if ($this->movement != null) {
            $this->fetchMovement();
        }

        $this->fetchMaterials();
    }

    public function fetchMovement()
    {
        $this->material = $this->movement->material;
        $this->materialId = $this->material->id;

        $this->supplier = $this->movement->supplier;
        $this->selectedSupplier = $this->supplier;
        $this->supplier_id = $this->supplier->id;
        $this->supplier_name = $this->supplier->owner_name;
        $this->supplier_num = $this->supplier->registration_number;
        $this->supplier_type = $this->supplier->person_type;

        $this->type = $this->movement->type;
        $this->quantity = $this->movement->quantity;
        $this->description = $this->movement->description;
        $this->reception_file = $this->movement->type;
        $this->validation = $this->movement->validation;
        $this->request_file = $this->movement->request_file;
        $this->approval_file = $this->movement->approval_file;
        $this->destiny = $this->movement->destiny;
        $this->responsable = $this->movement->responsable;
    }

    public function fetchMaterials()
    {
        $this->materials = AcquisitionMaterial::get();
    }

    public function fetchMaterial()
    {
        $this->materialId = $this->material->id;
    }

    public function updatedMaterialId($id)
    {
        $this->material = AcquisitionMaterial::findOrFail($id);
    }

    public function selectSupplier($supplier_id)
    {
        $supplier = \App\Models\Supplier::find($supplier_id);
        $this->selectedSupplier = $supplier;
        $this->supplier_id = $supplier->id;
        $this->supplier_name = $supplier->owner_name;
        $this->supplier_num = $supplier->registration_number;
        $this->supplier_type = $supplier->person_type;

        $this->searchSupplier = '';
    }

    public function createSupplier()
    {
        $this->newSupplier = true;
        $this->searchSupplier = '';
    }

    public function clearSupplier()
    {
        $this->supplier_id = '';
        $this->searchSupplier = '';
        $this->selectedSupplier = '';
        $this->supplier_name = '';
    }

    public function saveSupplier()
    {
        // Determinar el tipo de usuario (por defecto 'citizen')
        $userType = 'supplier';

        // Validación base para todos los usuarios
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'user_type' => ['sometimes', 'string', 'in:citizen,supplier,economist'],
        ];

        // Validación adicional si es proveedor
        if ($userType === 'supplier') {
            $rules['person_type'] = ['required', 'string', 'in:fisica,moral'];
            $rules['company_name'] = ['required_if:person_type,moral', 'nullable', 'string', 'max:255'];
            $rules['padron_status'] = ['required', 'string', 'in:con_padron,sin_padron'];
        }

        // Validar el formulario usando $this->validate()
        $this->validate($rules);

        // Crear el usuario
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Asignar rol según tipo de usuario
        $roleName = $this->getRoleNameByUserType($userType);
        $role = Role::firstOrCreate(['name' => $roleName]);
        $user->assignRole($role);

        // Preparar datos adicionales del usuario
        $supplier = new Supplier;

        $supplier->user_id = $user->id;
        $supplier->email = $user->email;
        $supplier->person_type = $this->person_type;
        $supplier->owner_name = $this->name;

        $year = date('Y');
        // Buscar último registro de este año
        $lastSupplier = Supplier::where('registration_number', 'LIKE', "PROV-$year-%")
            ->orderBy('registration_number', 'desc')
            ->first();

        if ($lastSupplier) {
            // Extraer últimos 5 dígitos
            $lastNumber = (int) substr($lastSupplier->registration_number, -5);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Formatear
        $registrationNumber = 'PROV-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // Asignar al modelo
        $supplier->registration_number = $registrationNumber;

        $supplier->save();

        $this->selectedSupplier = $supplier;
        $this->supplier_id = $supplier->id;
        $this->supplier_name = $supplier->owner_name;
        $this->supplier_num = $supplier->registration_number;
        $this->supplier_type = $supplier->person_type;

        $this->searchSupplier = '';

        $this->newSupplier = false;
    }

    private function getRoleNameByUserType(string $userType): string
    {
        $roleMap = [
            'citizen' => 'citizen',
            'supplier' => 'supplier',
        ];

        return $roleMap[$userType] ?? 'citizen';
    }

    public function cancelSupplier()
    {
        $this->newSupplier = false;
        $this->searchSupplier = '';

        $this->supplier_id = '';
        $this->supplier_name = '';
        $this->supplier_num = '';
        $this->supplier_type = '';
        $this->selectedSupplier = '';

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->person_type = '';
        $this->padron_status = '';
        $this->company_name = '';
    }

    public function inFile()
    {
        $file = public_path('files/acquisitions/acta-recepcion.docx');

        return response()->download($file);
    }

    public function save()
    {
        if ($this->movement != null) {

            $movement = AcquisitionInventoryMovement::findOrFail($this->movement->id);

            $movement->material_id = $this->material->id;

            $movement->type = $this->type;
            $movement->quantity = $this->quantity;

            if ($this->type == 'Entrada') {
                $movement->description = $this->description;
            } else {
                $movement->description = $this->description_exit;
            }

            // --- reception File ---
            $movement->reception_file = $this->reception_file
                ? $this->handleUpload($this->reception_file)
                : $movement->reception_file;

            $movement->validation = $this->validation;

            $movement->request_file = $this->request_file
                ? $this->handleUpload($this->request_file)
                : $movement->request_file;

            $movement->approval_file = $this->approval_file
                ? $this->handleUpload($this->approval_file)
                : $movement->approval_file;

            $movement->destiny = $this->destiny;
            $movement->responsable = $this->responsable;

            // --- Aplicar inventario sólo aquí
            app(\App\Services\InventoryService::class)
                ->applyToStock($this->movement);

            $movement->save();
        } else {
            $movement = new AcquisitionInventoryMovement;

            $movement->material_id = $this->material->id;
            $movement->supplier_id = $this->supplier_id;

            $movement->type = $this->type;
            $movement->quantity = $this->quantity;


            if ($this->type == 'Entrada') {
                $movement->description = $this->description;
            } else {
                $movement->description = $this->description_exit;
            }
            // --- reception File ---
            $movement->reception_file = $this->reception_file
                ? $this->handleUpload($this->reception_file)
                : $movement->reception_file;

            $movement->validation = $this->validation;

            $movement->request_file = $this->request_file
                ? $this->handleUpload($this->request_file)
                : $movement->request_file;

            $movement->approval_file = $this->approval_file
                ? $this->handleUpload($this->approval_file)
                : $movement->approval_file;

            $movement->destiny = $this->destiny;
            $movement->responsable = $this->responsable;

            $movement->save();


            $this->movement = $movement;

            // Generar PDF
            $pdf = PDF::loadView('acquisitions.inventory.utilities.pdf_income', [
                'movement' => $this->movement
            ]);

            // Guardar PDF temporalmente
            $fileName = 'ingreso-' . $this->movement->id . '.pdf';
            $filePath = storage_path('app/temp/' . $fileName);

            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0777, true);
            }

            $pdf->save($filePath);

            // Subir el PDF a S3
            $pdfUrl = $this->uploadPdfToS3($filePath, $this->movement);

            // Guardar URL en la columna file
            $movement->file = $pdfUrl;
            $movement->save();

            // Opcional: borrar archivo temporal
            unlink($filePath);

            // --- Aplicar inventario sólo aquí
            app(\App\Services\InventoryService::class)
                ->applyToStock($this->movement);

        }

        return redirect()->route('acquisitions.inventory.index');

    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'acquisitions/material/movements/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    protected function uploadPdfToS3($pdfPath, $movement)
    {
        $filename = 'ingreso-' . $movement->id . '.pdf';
        $filepath = 'acquisitions/material/movements/' . $filename;

        // Abrir archivo PDF ya generado
        $stream = fopen($pdfPath, 'r+');

        Storage::disk('s3')->put($filepath, $stream);

        if (is_resource($stream)) {
            fclose($stream);
        }

        // Regresar la URL pública del archivo en S3
        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        return view('acquisitions.inventory.utilities.movement');
    }
}
