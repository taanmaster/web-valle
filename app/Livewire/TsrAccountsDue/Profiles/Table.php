<?php

namespace App\Livewire\TsrAccountsDue\Profiles;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

// Modelos
use App\Models\TsrAccountDueProfile;

class Table extends Component
{
    use WithPagination;

    public $start_date = '';
    public $end_date = '';
    public $code = '';

    public function resetFilters()
    {
        $this->started_date = '';
        $this->end_date = '';
        $this->code = '';
    }

    public function render()
    {

        $query = TsrAccountDueProfile::query();

        if ($this->start_date !== '') {
            $query->whereDate('created_at', '>=', $this->start_date);
        }
        if ($this->end_date !== '') {
            $query->whereDate('created_at', '<=', $this->end_date);
        }


        if ($this->code !== '') {
            $query->where('code', 'like', '%' . $this->code . '%');
        }

        $profiles = $query->latest()->paginate(8);

        return view('tsr_accounts_due.profiles.utilities.table', [
            'profiles' => $profiles,
        ]);
    }
}
