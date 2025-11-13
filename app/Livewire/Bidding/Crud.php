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
    public $addFile = false;

    //Campos
    public $folio = '';
    public $title = '';
    public $status = '';
    public $dependency_name = '';
    public $ammount = '';
    public $service = '';
    public $justification = '';
    public $requirement_file = '';
    public $request_file = '';
    public $bidding_type = '';


    public function mount()
    {
        if ($this->mode == 0) {
            // Guardar datos en la base de datos
            $bidding = new Bidding;
            $bidding->status = 'Nueva Licitación';
            $bidding->save();

            $this->bidding = $bidding;
        }

        if ($this->bidding != null) {
            $this->fetchBidding();
        }

    }

    public function fetchBidding()
    {
        $this->folio = $this->bidding->id;
        $this->title = $this->bidding->title;
        $this->status = $this->bidding->status;
        $this->dependency_name = $this->bidding->dependency_name;
        $this->ammount = $this->bidding->ammount;
        $this->service = $this->bidding->service;
        $this->justification = $this->bidding->justification;
        $this->requirement_file = $this->bidding->requirement_file;
        $this->request_file = $this->bidding->request_file;
        $this->bidding_type = $this->bidding->bidding_type;
    }

    public function render()
    {
        return view('acquisitions.bidding.utilities.crud');
    }
}
