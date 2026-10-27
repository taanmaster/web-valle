<?php

namespace App\Livewire\Market\Rates;

use App\Models\MarketRate;
use Livewire\Component;
use Session;

class Form extends Component
{
    public ?MarketRate $rate = null;

    public $fiscal_year;

    public $space_type = '';

    public $article = '11';

    public $subsection = '';

    public $fraction = '';

    public $monthly_amount = '';

    public $description = '';

    public $effective_from;

    public function mount(?MarketRate $rate = null)
    {
        if ($rate?->exists) {
            $this->rate = $rate;
            $this->fill($rate->only(['fiscal_year', 'space_type', 'article', 'subsection', 'fraction', 'monthly_amount', 'description']));
            $this->effective_from = $rate->effective_from->toDateString();
        } else {
            $this->fiscal_year = now()->year;
            $this->effective_from = now()->startOfYear()->toDateString();
        }
    }

    public function save()
    {
        $data = $this->validate([
            'fiscal_year' => 'required|integer|min:2020|max:2100',
            'space_type' => 'required|in:'.implode(',', array_keys(MarketRate::SPACE_TYPES)),
            'article' => 'required|string|max:10',
            'subsection' => 'required|string|max:10',
            'fraction' => 'required|string|max:10',
            'monthly_amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'effective_from' => 'required|date',
        ], [], [
            'fiscal_year' => 'ejercicio fiscal', 'space_type' => 'tipo de espacio', 'article' => 'artículo',
            'subsection' => 'inciso', 'fraction' => 'fracción', 'monthly_amount' => 'monto mensual',
            'description' => 'descripción', 'effective_from' => 'vigente desde',
        ]);

        $data['subsection'] = mb_strtoupper($data['subsection']);
        $data['fraction'] = mb_strtoupper($data['fraction']);

        $this->rate ? $this->rate->update($data) : MarketRate::create($data);

        Session::flash('success', 'Tarifa guardada correctamente.');

        return redirect()->route('market.rates.index');
    }

    public function render()
    {
        return view('livewire.market.rates.form', [
            'linked' => $this->rate?->stalls()->count() ?? 0,
            'preview' => (MarketRate::SPACE_TYPES[$this->space_type] ?? 'Tipo')
                .' · Art. '.($this->article ?: '—').' · Inc. '.(mb_strtoupper($this->subsection) ?: '—')
                .' · Frac. '.(mb_strtoupper($this->fraction) ?: '—').' · $'.number_format((float) $this->monthly_amount, 2),
        ]);
    }
}
