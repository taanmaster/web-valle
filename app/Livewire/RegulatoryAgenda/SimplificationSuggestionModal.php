<?php

namespace App\Livewire\RegulatoryAgenda;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelos
use App\Models\SimplificationAgendaSuggestion;

class SimplificationSuggestionModal extends Component
{

    public $simplification;
    public $dependency;

    public $name = '';
    public $description = '';

    #[On('newSimplificationSuggestion')]
    public function new($id)
    {
        $this->simplification = $id;
        $this->name = '';
        $this->description = '';
    }

    public function save()
    {
        SimplificationAgendaSuggestion::create([
            'simplification_id' => $this->simplification,
            'name' => $this->name,
            'description' => $this->description,
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Sugerencia creada correctamente.');

        // Redirigir
        return redirect()->route('regulatory-agenda-dependency.show', $this->dependency);
    }

    public function render()
    {
        return view('livewire.regulatory-agenda.simplification-suggestion-modal');
    }
}
