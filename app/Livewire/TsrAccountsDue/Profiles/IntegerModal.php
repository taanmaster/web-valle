<?php

namespace App\Livewire\TsrAccountsDue\Profiles;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

// Modelos
use App\Models\TransparencyDependency;
use App\Models\TsrAccountDueProvisionalInteger;
use App\Models\TsrAccountDueProfile;

class IntegerModal extends Component
{
    // Dependencias de tesorería
    public $dependencies = [];

    //Perfil de cobro
    public $profile;

    //Entero
    public $integer;

    public $today;
    public $folio = '';

    // Campos
    #[Validate('required')]
    public $account_due_profile_id = '';
    public $dependency_name = '';
    public $qty_text = '';
    public $qty_integer = '';
    public $name = '';
    public $address = '';
    public $zipcode = '';
    public $basis = '';
    public $concept = '';
    public $payment_method = '';
    public $payment_date = '';
    public $created_by = '';
    public $director = '';


    #[On('selectInteger')]
    public function showModal($id)
    {
        $this->integer = TsrAccountDueProvisionalInteger::find($id);

        $this->fetchIntegerData();
    }

    #[On('selectProfile')]
    public function showModalNew($id)
    {
        $this->profile = TsrAccountDueProfile::find($id);

        $this->resetForm();

        $this->mount();
    }

    public function mount()
    {
        // Cargar las dependencias de transparencia
        $this->dependencies = TransparencyDependency::where('belongs_to_treasury', true)->get();

        $this->today = Carbon::now()->format('Y-m-d');

        if ($this->integer != null) {
            $this->fetchIntegerData();
        }

        if ($this->profile != null) {
            // Si se pasa un perfil, cargar sus datos
            $this->account_due_profile_id = $this->profile->id;
            $this->name = $this->profile->name;
            $this->address = $this->profile->address;
            $this->zipcode = $this->profile->zipcode;
            $this->payment_date = $this->today;
        }
    }

    public function fetchIntegerData()
    {
        $this->folio = $this->integer->id;
        $this->account_due_profile_id = $this->integer->account_due_profile_id;
        $this->dependency_name = $this->integer->dependency_name;
        $this->qty_text = $this->integer->qty_text;
        $this->qty_integer = $this->integer->qty_integer;
        $this->name = $this->integer->name;
        $this->address = $this->integer->address;
        $this->zipcode = $this->integer->zipcode;
        $this->basis = $this->integer->basis;
        $this->concept = $this->integer->concept;
        $this->payment_method = $this->integer->payment_method;
        $this->director = $this->integer->director;
        $this->payment_date = $this->integer->created_at;
        $this->created_by = $this->integer->created_by;
    }

    public function save()
    {
        $this->validate();

        // Crear un nuevo registro de TsrAccountDueProvisionalInteger
        TsrAccountDueProvisionalInteger::create([
            'account_due_profile_id' => $this->account_due_profile_id,
            'dependency_name' => $this->dependency_name,
            'qty_text' => $this->qty_text,
            'qty_integer' => $this->qty_integer,
            'name' => $this->name,
            'address' => $this->address,
            'zipcode' => $this->zipcode,
            'basis' => $this->basis,
            'concept' => $this->concept,
            'payment_method' => $this->payment_method,
            'created_by' => $this->created_by,
            'director' => $this->director,
        ]);

        // Reiniciar el formulario
        $this->resetForm();

        // Mensaje de sesión
        Session::flash('success', 'Entero creado correctamente.');

        // Mensaje de sesión
        return redirect()->route('account_due_profiles.show', $this->profile->id);
    }

    public function resetForm()
    {
        $this->account_due_profile_id = '';
        $this->dependency_name = '';
        $this->qty_text = '';
        $this->qty_integer = '';
        $this->name = '';
        $this->address = '';
        $this->zipcode = '';
        $this->basis = '';
        $this->concept = '';
        $this->payment_method = '';
        $this->payment_date = '';
        $this->created_by = '';
        $this->director = '';

        // Reiniciar el entero
        $this->integer = null;
    }

    public function render()
    {
        return view('tsr_accounts_due.profiles.utilities.integer-modal');
    }
}
