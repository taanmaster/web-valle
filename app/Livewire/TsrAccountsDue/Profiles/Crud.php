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
use App\Models\TsrBillingAccount;

class Crud extends Component
{

    //Modes: 0: create, 1 show, 2 edit
    public $mode;



    public function render()
    {
        return view('tsr_accounts_due.profiles.utilities.crud');
    }
}
