<?php

namespace App\Livewire\Ayuda;

use App\Models\Guia;
use Livewire\Component;

class GuiaDetalle extends Component
{
    public $guia;

    public string $context = 'front';

    public function mount(Guia $guia, string $context = 'front'): void
    {
        $this->guia = $guia->load('pasos', 'categoria');
        $this->context = $context;
    }

    public function render()
    {
        return view('ayuda.utilities.guia-detalle', [
            'total' => $this->guia->pasos->count(),
        ]);
    }
}
