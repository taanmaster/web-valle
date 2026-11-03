<?php

namespace App\Livewire\Market\Stalls;

use App\Models\MarketRate;
use App\Models\MarketStall;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Session;

class Form extends Component
{
    public ?MarketStall $stall = null;

    public $tenant_name = '';

    public $phone = '';

    public $number = '';

    public $space_type = '';

    public $space_number = '';

    public $aisle = '';

    public $location = '';

    public $business = '';

    public $market_rate_id = '';

    public $registered_at;

    /** Mes desde el que debe pagar, formato YYYY-MM */
    public $billing_month;

    public function mount(?MarketStall $stall = null)
    {
        if ($stall?->exists) {
            $this->stall = $stall;
            $this->fill($stall->only(['tenant_name', 'phone', 'number', 'space_type', 'space_number', 'aisle', 'location', 'business', 'market_rate_id']));
            $this->registered_at = $stall->registered_at->toDateString();
            $this->billing_month = $stall->billing_start->format('Y-m');
        } else {
            $this->number = MarketStall::nextNumber();
            $this->registered_at = now()->toDateString();
            $this->billing_month = now()->format('Y-m');
        }
    }

    public function updatedSpaceType()
    {
        $this->market_rate_id = '';
    }

    public function save()
    {
        $data = $this->validate([
            'tenant_name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'number' => ['required', 'string', 'max:20', Rule::unique('market_stalls', 'number')->ignore($this->stall?->id)],
            'space_type' => 'required|in:'.implode(',', array_keys(MarketRate::SPACE_TYPES)),
            'space_number' => 'required|string|max:20',
            'aisle' => 'nullable|string|max:20',
            'location' => 'required|in:'.implode(',', MarketStall::LOCATIONS),
            'business' => 'required|string|max:255',
            'market_rate_id' => ['required', Rule::exists('market_rates', 'id')->where('space_type', $this->space_type)],
            'registered_at' => 'required|date',
            'billing_month' => 'required|date_format:Y-m',
        ], [], [
            'tenant_name' => 'nombre completo', 'phone' => 'teléfono', 'number' => 'núm. de padrón',
            'space_type' => 'tipo de espacio', 'space_number' => 'núm. de espacio', 'location' => 'ubicación',
            'business' => 'giro', 'market_rate_id' => 'tarifa', 'billing_month' => 'mes desde el que debe pagar',
        ]);

        $data['billing_start'] = $data['billing_month'].'-01';
        unset($data['billing_month']);

        $stall = $this->stall ? tap($this->stall)->update($data) : MarketStall::create($data);

        Session::flash('success', 'Registro de padrón guardado.');

        return redirect()->route('market.stalls.show', $stall);
    }

    public function render()
    {
        $rates = $this->space_type
            ? MarketRate::where('space_type', $this->space_type)
                ->where(fn ($q) => $q->where('is_active', true)->orWhere('id', $this->market_rate_id ?: 0))
                ->orderByDesc('fiscal_year')->orderBy('fraction')->get()
            : collect();

        return view('livewire.market.stalls.form', [
            'rates' => $rates,
            'selectedRate' => $rates->firstWhere('id', (int) $this->market_rate_id),
        ]);
    }
}
