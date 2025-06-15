<?php

namespace App\Livewire\TsrAccountsDue\ProvisionalInteger;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

// Modelos
use App\Models\TransparencyDependency;
use App\Models\TsrAccountDueProvisionalInteger;
use App\Models\TsrAccountDueProfile;

class Table extends Component
{
    use WithPagination;

    public $profile = '';

    public $start_date = '';
    public $end_date = '';
    public $folio = '';
    public $dependency_name = []; // Ahora es un array

    public $dependencies = [];

    #[On('select')]
    public function listenerReferenceHere($selectedValue)
    {

        if ($selectedValue != null) {

            if (!in_array($selectedValue, $this->dependency_name)) {
                $this->dependency_name[] = $selectedValue;
            }
        }
    }

    public function mount()
    {
        // Cargar las dependencias de transparencia
        $this->dependencies = TransparencyDependency::where('belongs_to_treasury', true)->get();
    }

    public function resetFilters()
    {
        $this->start_date = '';
        $this->end_date = '';
        $this->folio = '';
        $this->dependency_name = [];
    }

    public function render()
    {

        $query = TsrAccountDueProvisionalInteger::query();

        if ($this->profile !== '') {
            $query->where('account_due_profile_id', $this->profile);
        }

        if ($this->start_date) {
            $query->whereDate('created_at', '>=', $this->start_date);
        }
        if ($this->end_date) {
            $query->whereDate('created_at', '<=', $this->end_date);
        }
        if ($this->folio !== '') {
            $query->where('id', 'like', '%' . $this->folio . '%');
        }
        if (!empty($this->dependency_name)) {
            $query->whereIn('dependency_name', $this->dependency_name);
        }

        $integers = $query->latest()->paginate(8);

        return view('tsr_accounts_due.provisional_integers.utilities.table', [
            'integers' => $integers,
        ]);
    }
}
