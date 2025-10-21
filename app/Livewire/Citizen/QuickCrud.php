<?php

namespace App\Livewire\Citizen;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

use App\Models\Citizen;
use App\Models\User;

class QuickCrud extends Component
{
    public $step = 1;

    public $name = '';
    public $lastname = '';
    public $email = '';

    public $pass = '';

    public $new_citizen;


    public function save()
    {
        $password = Str::random(8);

        $this->pass = $password;

        $user = new User([
            'name' => $this->name . ' ' . $this->lastname,
            'email' => $this->email,
            'password' => bcrypt($password),
        ]);

        // Guardar el ciudadano
        $user->save();

        // Asignar el rol user
        $user->assignRole('citizen');


        $citizen = $this->getOrCreateCitizenProfile($user);
        $citizen->update([
            'name' => $this->name . ' ' . $this->lastname,
            'first_name' => '',
            'last_name' => '',
            'email' => $this->email,
        ]);

        $this->new_citizen = $citizen;

        Session::flash('success', 'El usuario ciudadano se creó exitosamente.');

        $this->step = 2;
    }

    private function getOrCreateCitizenProfile($user)
    {
        $citizen = Citizen::where('email', $user->email)->first();

        if (!$citizen) {
            $citizen = Citizen::create([
                'name' => $user->name,
                'first_name' => '', // Podrías separar el nombre si es necesario
                'last_name' => '',
                'email' => $user->email,
                'phone' => null,
                'curp' => null,
            ]);
        }

        return $citizen;
    }

    public function sendUser()
    {
        $this->dispatch('user-created', id: $this->new_citizen->id);
    }

    public function render()
    {
        return view('citizens.utilities.quick-crud');
    }
}
