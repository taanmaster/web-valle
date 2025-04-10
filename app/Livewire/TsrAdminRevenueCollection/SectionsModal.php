<?php

namespace App\Livewire\TsrAdminRevenueCollection;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;

//Modelos
use App\Models\TsrAdminRevenueColletionSection;

class SectionsModal extends Component
{

    public $section;

    #[Validate('required|max:255')]
    public $name = '';

    public $description = '';


    #[On('selectSection')]
    public function showModal($id)
    {
        $this->section = TsrAdminRevenueColletionSection::find($id);

        $this->name = $this->section->name;
        $this->description = $this->section->description;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:500',
        ]);

        if ($this->section != null) {
            $this->section->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Sección actualizada correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.index');
        } else {
            TsrAdminRevenueColletionSection::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Sección creada correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.index');
        }
    }

    public function render()
    {
        return view('tsr_admin_revenue_collection.utilities.sections-modal');
    }
}
