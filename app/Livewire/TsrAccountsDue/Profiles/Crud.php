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
use App\Models\TsrAccountDueProfile;

class Crud extends Component
{

    public $profile;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;


    // Campos
    #[Validate('required')]
    public $name = '';
    public $rfc_curp = '';
    public $typeOfPerson = ''; // Persona física o moral
    public $email = '';
    public $phone = '';
    public $address = '';
    public $zipcode = '';
    public $code = '';
    public $created_date = '';
    public $today;

    public function mount()
    {

        $this->today = Carbon::now()->format('Y-m-d');

        $this->code = strtoupper(Str::random(10)); // Alfanumérico, 10 caracteres, en mayúsculas

        if ($this->profile != null) {
            $this->fetchProfileData();
        }
    }

    public function fetchProfileData()
    {
        $this->name = $this->profile->name;
        $this->rfc_curp = $this->profile->rfc_curp;
        $this->typeOfPerson = $this->profile->type_of_person;
        $this->email = $this->profile->email;
        $this->phone = $this->profile->phone;
        $this->address = $this->profile->address;
        $this->zipcode = $this->profile->zipcode;
        $this->code = $this->profile->code;
        $this->created_date = $this->profile->created_at->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        if ($this->profile != null) {

            $this->profile->update([
                'name' => $this->name,
                'rfc_curp' => $this->rfc_curp,
                'type_of_person' => $this->typeOfPerson,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'zipcode' => $this->zipcode,
                'code' => $this->code,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Cuenta actualizada correctamente.');


            // Mensaje de sesión
            return redirect()->route('account_due_profiles.show', $this->profile->id);

        } else {

            TsrAccountDueProfile::create([
                'name' => $this->name,
                'rfc_curp' => $this->rfc_curp,
                'type_of_person' => $this->typeOfPerson,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'zipcode' => $this->zipcode,
                'code' => $this->code,
            ]);

            // Crear el perfil
            $this->profile = TsrAccountDueProfile::where('code', $this->code)->first();

            // Mensaje de sesión
            Session::flash('success', 'Cuenta creada correctamente.');


            // Mensaje de sesión
            return redirect()->route('account_due_profiles.show', $this->profile->id);

        }
    }


    public function render()
    {
        return view('tsr_accounts_due.profiles.utilities.crud');
    }
}
