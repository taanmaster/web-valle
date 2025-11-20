<?php

namespace App\Livewire\Bidding\Proposal;

use Livewire\Component;

// Ayudantes
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

//Models
use App\Models\Bidding;
use App\Models\BiddingProposal;
use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class Crud extends Component
{
    use WithFileUploads;

    public $proposal;
    public $bidding;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    //Propuesta
    public $file_name = '';
    public $file = '';

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

    public function mount($bidding)
    {
        $this->clearAll();


        $this->bidding = $bidding;
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

    public function save()
    {
        $this->dispatch('closeModal');

        // Validación
        $this->validate([
            'file_name' => 'required|string|max:255',
            'file' => $this->file ? 'required|file|mimes:pdf,doc,docx|max:102400' : 'required|file|mimes:pdf,doc,docx|max:102400',
        ], [
            'name.required' => 'El nombre de archivo es obligatorio.',
            'file.required' => 'Debes subir un archivo.',
            'file.mimes' => 'El archivo debe ser PDF, DOC o DOCX.',
        ]);

        $proposal = new BiddingProposal;

        $proposal->bidding_id = $this->bidding->id;
        $proposal->supplier_id = $this->supplier_id;
        $proposal->file_name = $this->file_name;
        // --- Request File ---
        $proposal->file = $this->file
            ? $this->handleUpload($this->file)
            : $proposal->file;

        $proposal->save();

        $proposal->bidding->updateStatus();

        // Emitir evento global
        $this->dispatch('proposalSaved', id: $this->bidding->id);

        $this->clearAll();

        Session::flash('message', 'Propuesta creada correctamente.');

        return route('acquisitions.biddings.show', $proposal->bidding->id);

    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'acquisitions/biddings/proposals/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function clearAll()
    {
        $this->file_name = '';
        $this->file = '';
        $this->supplier_id = '';
        $this->supplier_name = '';
        $this->supplier_num = '';
        $this->supplier_type = '';
        $this->searchSupplier = '';
        $this->selectedSupplier = '';

        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->person_type = '';
        $this->padron_status = '';
        $this->company_name = '';
    }

    public function render()
    {
        return view('livewire.bidding.proposal.crud');
    }
}
