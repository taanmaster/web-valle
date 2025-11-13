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

//Models
use App\Models\Bidding;
use App\Models\BiddingProposal;
use App\Models\Supplier;

class Crud extends Component
{
    use WithFileUploads;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    //Propuesta
    public $file_name = '';
    public $file = '';

    //Proveedor
    public $newSupplier = false;
    public $supplier_name = '';
    public $supplier_type = '';

    public $selectedSupplier = '';

    public function save()
    {

    }

    public function render()
    {
        return view('livewire.bidding.proposal.crud');
    }
}
