<?php

namespace App\Livewire\Ayuda;

use Livewire\Component;
use App\Models\Guia;

class GuiaDetalle extends Component
{
    public $guia;
    public string $context = 'front';
    public int $currentStepIndex = 0;

    public function mount(Guia $guia, string $context = 'front'): void
    {
        $this->guia    = $guia->load('pasos', 'categoria');
        $this->context = $context;
    }

    public function goToStep(int $index): void
    {
        $max = $this->guia->pasos->count() - 1;
        $this->currentStepIndex = max(0, min($index, $max));
    }

    public function nextStep(): void
    {
        $this->goToStep($this->currentStepIndex + 1);
    }

    public function prevStep(): void
    {
        $this->goToStep($this->currentStepIndex - 1);
    }

    public function render()
    {
        $paso = $this->guia->pasos->get($this->currentStepIndex);

        return view('ayuda.utilities.guia-detalle', [
            'paso'  => $paso,
            'total' => $this->guia->pasos->count(),
        ]);
    }
}
