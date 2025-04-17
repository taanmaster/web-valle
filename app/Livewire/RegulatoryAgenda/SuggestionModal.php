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
use App\Models\RegulatoryAgendaSuggestion;

class SuggestionModal extends Component
{

    public $regulation;
    public $dependency;

    public $name = '';
    public $description = '';

    #[On('newSuggestion')]
    public function new($id)
    {
        $this->regulation = $id;
        $this->name = '';
        $this->description = '';
    }

    public function save()
    {
        RegulatoryAgendaSuggestion::create([
            'regulation_id' => $this->regulation,
            'name' => $this->name,
            'description' => $this->description,
        ]);

        // Mensaje de sesión
        Session::flash('success', 'Sugerencía creado correctamente.');

        // Redirigir
        return redirect()->route('regulatory-agenda-dependency.show', $this->dependency);
    }

    public function render()
    {
        return view('regulatory_agenda_suggestions.suggestion-modal');
    }
}
