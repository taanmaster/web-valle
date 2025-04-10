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
use App\Models\TsrAdminRevenueColletionFraction;
use App\Models\TsrAdminRevenueColletionArticle;

class FractionModal extends Component
{

    public $selectedFraction;

    #[Validate('required|max:255')]
    public $name = '';
    public $fraction = '';

    public $description = '';
    public $articleId;

    #[On('selectFraction')]
    public function showModal($id)
    {
        $this->selectedFraction = TsrAdminRevenueColletionFraction::find($id);

        $this->name = $this->selectedFraction->name;
        $this->fraction = $this->selectedFraction->fraction;
        $this->description = $this->selectedFraction->description;
    }


    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'fraction' => 'required|max:255',
            'description' => 'nullable|max:500',
        ]);

        if ($this->selectedFraction != null) {
            $this->selectedFraction->update([
                'name' => $this->name,
                'fraction' => $this->fraction,
                'description' => $this->description,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Fracción actualizada correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.show', $this->articleId);
        } else {
            TsrAdminRevenueColletionFraction::create([
                'article_id' => $this->articleId,
                'name' => $this->name,
                'fraction' => $this->fraction,
                'description' => $this->description,
            ]);

            // Mensaje de sesión
            Session::flash('success', 'Fracción creada correctamente.');

            // Redirigir
            return redirect()->route('trs_admin_revenue_collection.show', $this->articleId);
        }
    }


    public function render()
    {
        return view('tsr_admin_revenue_collection.utilities.fraction-modal');
    }
}
