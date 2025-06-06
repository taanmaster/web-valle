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
    public $rfcCurp = '';
    public $typeOfPerson = ''; // Persona física o moral
    public $email = '';
    public $phone = '';
    public $address = '';
    public $zipcode = '';
    public $code = '';
    public $today;

    public function mount()
    {
        if ($this->profile != null) {
            $this->fetchProfileData();
        }

        $this->today = Carbon::now()->format('Y-m-d');
    }

    public function fetchProfileData()
    {
        $this->name = $this->profile->name;
        $this->rfcCurp = $this->profile->rfc_curp;
        $this->typeOfPerson = $this->profile->type_of_person;
        $this->email = $this->profile->email;
        $this->phone = $this->profile->phone;
        $this->address = $this->profile->address;
        $this->zipcode = $this->profile->zipcode;
        $this->code = $this->profile->code;
    }

    public function save()
    {
        $this->validate();

        if ($this->profile != null) {

            $this->profile->update([
                'name' => $this->name,
                'rfc_curp' => $this->rfcCurp,
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

            // Generar un código único para el perfil
            $unique_code = strtoupper(Str::random(10)); // Alfanumérico, 10 caracteres, en mayúsculas


            TsrAccountDueProfile::create([
                'name' => $this->name,
                'rfc_curp' => $this->rfcCurp,
                'type_of_person' => $this->typeOfPerson,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'zipcode' => $this->zipcode,
                'code' => $unique_code,
            ]);

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
