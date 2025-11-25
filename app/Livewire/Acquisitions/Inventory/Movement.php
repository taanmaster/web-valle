<?php

namespace App\Livewire\Acquisitions\Inventory;

use Livewire\Component;

class Movement extends Component
{
    public $material;

    public $movement;

    //Modos: 0 Sin material seleccionado, 1 Creado desde el material
    public $mode = 0;




    public function render()
    {
        return view('acquisitions.inventory.utilities.movement');
    }
}
