<?php

namespace App\Livewire\Market\Rates;

use App\Models\MarketRate;
use Livewire\Component;
use Session;

class Table extends Component
{
    public $filterYear = '';

    public $filterType = '';

    public $filterStatus = '';

    public function clearFilters()
    {
        $this->reset(['filterYear', 'filterType', 'filterStatus']);
    }

    public function toggle($id)
    {
        $rate = MarketRate::findOrFail($id);
        $rate->update(['is_active' => ! $rate->is_active]);
    }

    /**
     * Copia las tarifas activas del ejercicio más reciente al siguiente, para no recapturarlas cada año
     */
    public function copyToNextYear()
    {
        $latest = MarketRate::max('fiscal_year');
        $next = $latest + 1;

        if (MarketRate::where('fiscal_year', $next)->exists()) {
            Session::flash('error', 'Ya existen tarifas del ejercicio '.$next.'.');

            return;
        }

        MarketRate::where('fiscal_year', $latest)->where('is_active', true)->get()
            ->each(fn ($rate) => $rate->replicate()->fill([
                'fiscal_year' => $next,
                'effective_from' => $next.'-01-01',
            ])->save());

        Session::flash('success', 'Tarifas copiadas al ejercicio '.$next.'. Ajusta los montos si cambiaron.');
        $this->filterYear = $next;
    }

    public function render()
    {
        $rates = MarketRate::withCount('stalls')
            ->when($this->filterYear, fn ($q) => $q->where('fiscal_year', $this->filterYear))
            ->when($this->filterType, fn ($q) => $q->where('space_type', $this->filterType))
            ->when($this->filterStatus !== '', fn ($q) => $q->where('is_active', $this->filterStatus === 'activa'))
            ->orderByDesc('fiscal_year')->orderBy('space_type')->orderBy('fraction')
            ->get();

        return view('livewire.market.rates.table', [
            'rates' => $rates,
            'years' => MarketRate::distinct()->orderByDesc('fiscal_year')->pluck('fiscal_year'),
        ]);
    }
}
