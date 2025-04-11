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
use App\Models\TsrAdminRevenueColletionClause;

class ClauseModal extends Component
{

    public $articleId;
    public $fractionId;

    public $selectedClause;

    public $clause = '';
    public $name = '';
    public $description = '';
    public $units = '';
    public $quote = '';


    #[On('newClause')]
    public function new($id)
    {
        $this->fractionId = $id;
        $this->selectedClause = '';

        $this->clause = '';
        $this->name = '';
        $this->description = '';
        $this->units = '';
        $this->quote = '';
    }

    #[On('selectClause')]
    public function selectClause($id)
    {
        $this->selectedClause = TsrAdminRevenueColletionClause::find($id);

        $this->clause = $this->selectedClause->clause;
        $this->name = $this->selectedClause->name;
        $this->description = $this->selectedClause->description;
        $this->units = $this->selectedClause->units;
        $this->quote = $this->selectedClause->quote;
    }

    public function save()
    {
        if ($this->selectedClause != null) {
            $this->selectedClause->update([
                'clause' => $this->clause,
                'name' => $this->name,
                'description' => $this->description,
                'units' => $this->units,
                'quote' => $this->quote
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Inciso actualizado correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.show', $this->articleId);
        } else {
            TsrAdminRevenueColletionClause::create([
                'fraction_id' => $this->fractionId,
                'clause' => $this->clause,
                'name' => $this->name,
                'description' => $this->description,
                'units' => $this->units,
                'quote' => $this->quote
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Inciso creado correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.show', $this->articleId);
        }
    }

    public function render()
    {
        return view('tsr_admin_revenue_collection.utilities.clause-modal');
    }
}
