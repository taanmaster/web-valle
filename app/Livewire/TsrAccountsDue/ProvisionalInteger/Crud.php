<?php

namespace App\Livewire\TsrAccountsDue\ProvisionalInteger;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

// Modelos
use App\Models\TsrAccountDueProvisionalInteger;
use App\Models\TsrAccountDueProfile;


class Crud extends Component
{
    public function render()
    {
        return view('livewire.tsr-accounts-due.provisional-integer.crud');
    }
}
