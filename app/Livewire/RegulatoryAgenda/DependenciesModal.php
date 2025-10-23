<?php

namespace App\Livewire\RegulatoryAgenda;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

// Modelos
use App\Models\RegulatoryAgendaDependency;

class DependenciesModal extends Component
{

    public $dependency;

    public $name = '';
    public $description = '';
    public $in_index = false;

    public $fullname_connection = '';
    public $title_connection = '';
    public $fullname_lider = '';
    public $title_lider = '';

    #[On('newDependency')]
    public function new()
    {
        $this->dependency = '';

        $this->name = '';
        $this->description = '';
        $this->in_index = false;
        $this->fullname_connection = '';
        $this->title_connection = '';
        $this->fullname_lider = '';
        $this->title_lider = '';
    }

    #[On('selectDependency')]
    public function showModal($id)
    {
        $this->dependency = RegulatoryAgendaDependency::find($id);

        $this->name = $this->dependency->name;
        $this->description = $this->dependency->description;
        $this->in_index = (bool) $this->dependency->in_index;
        $this->fullname_connection = $this->dependency->fullname_connection;
        $this->title_connection = $this->dependency->title_connection;
        $this->fullname_lider = $this->dependency->fullname_lider;
        $this->title_lider = $this->dependency->title_lider;
    }

    public function save()
    {
        if ($this->dependency != null) {
            $this->dependency->update([
                'name' => $this->name,
                'description' => $this->description,
                'in_index' => $this->in_index,
                'fullname_connection' => $this->fullname_connection,
                'title_connection' => $this->title_connection,
                'fullname_lider' => $this->fullname_lider,
                'title_lider' => $this->title_lider
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Dependencia actualizada correctamente.');

            // Redirigir
            return redirect()->route('regulatory_agenda.index');
        } else {
            RegulatoryAgendaDependency::create([
                'name' => $this->name,
                'description' => $this->description,
                'in_index' => $this->in_index,
                'fullname_connection' => $this->fullname_connection,
                'title_connection' => $this->title_connection,
                'fullname_lider' => $this->fullname_lider,
                'title_lider' => $this->title_lider
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Dependencia creada correctamente.');

            // Redirigir
            return redirect()->route('regulatory_agenda.index');
        }
    }

    public function render()
    {
        return view('regulatory_agenda.utilities.dependencies-modal');
    }
}
