<?php

namespace App\Livewire\HR\Vacancy;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\HRVacancy;

class EntriesTable extends Component
{
    use WithPagination;

    public $status_filter = '';
    public $search = '';

    public function resetFilters()
    {
        $this->status_filter = '';
        $this->search = '';
    }

    public function render()
    {
        $query = HRVacancy::query();

        if ($this->search) {
            $query->where('position_name', 'like', '%' . $this->search . '%');
        }

        if ($this->status_filter) {
            $now = now();
            switch ($this->status_filter) {
                case 'Programada':
                    $query->where('published_at', '>', $now);
                    break;
                case 'Abierta':
                    $query->where(function ($q) use ($now) {
                        $q->where('published_at', '<=', $now)
                          ->where(function ($q2) use ($now) {
                              $q2->where('closing_date', '>', $now)
                                 ->orWhereNull('closing_date');
                          });
                    });
                    break;
                case 'Cerrada':
                    $query->where('closing_date', '<', $now);
                    break;
            }
        }

        $vacancies = $query->latest()->paginate(10);

        return view('hr.vacancies.utilities.entries-table', [
            'vacancies' => $vacancies,
        ]);
    }
}
