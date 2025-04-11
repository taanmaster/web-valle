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
use App\Models\TsrAdminRevenueColletionVariant;
use App\Models\TsrAdminRevenueColletionClause;

class VariantModal extends Component
{

    public $articleId;
    public $clauseId;

    public $selectedVariant;

    public $name = '';
    public $description = '';
    public $units = '';
    public $quote = '';
    public $clause = '';

    #[On('newVariant')]
    public function new($id)
    {
        $this->clauseId = $id;
        $clause = TsrAdminRevenueColletionClause::find($id);

        $this->clause = $clause->name;
        $this->name = '';
        $this->description = '';
        $this->units = '';
        $this->quote = '';
    }

    #[On('selectVariant')]
    public function selectVariant($id)
    {
        $this->selectedVariant = TsrAdminRevenueColletionVariant::find($id);
        $this->clause = $this->selectedVariant->clause->name;

        $this->name = $this->selectedVariant->name;
        $this->description = $this->selectedVariant->description;
        $this->units = $this->selectedVariant->units;
        $this->quote = $this->selectedVariant->quote;
    }

    public function save()
    {
        if ($this->selectedVariant != null) {

            $this->selectedVariant->update([
                'name' => $this->name,
                'description' => $this->description,
                'units' => $this->units,
                'quote' => $this->quote
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Variante actualizada correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.show', $this->articleId);
        } else {

            TsrAdminRevenueColletionVariant::create([
                'clause_id' => $this->clauseId,
                'name' => $this->name,
                'description' => $this->description,
                'units' => $this->units,
                'quote' => $this->quote
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Variante creada correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.show', $this->articleId);
        }
    }


    public function render()
    {
        return view('tsr_admin_revenue_collection.utilities.variant-modal');
    }
}
