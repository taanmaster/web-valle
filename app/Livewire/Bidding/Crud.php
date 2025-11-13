<?php

namespace App\Livewire\Bidding;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

//Modelo
use App\Models\Bidding;

use Livewire\Component;

class Crud extends Component
{
    use WithFileUploads;

    public $bidding;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    public $tab;


    public function mount()
    {
        if ($this->bidding != null) {
            $this->fetchBidding();
        }
    }

    public function fetchBidding()
    {

    }

    public function render()
    {
        return view('acquisitions.bidding.utilities.crud');
    }
}
