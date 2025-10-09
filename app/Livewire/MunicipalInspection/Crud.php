<?php

namespace App\Livewire\MunicipalInspection;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

use App\Models\MunicipalInspection;

class Crud extends Component
{
    public function render()
    {
        return view('municipal_inspections.utilities.crud');
    }
}
