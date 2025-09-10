<?php

namespace App\Livewire\Implan\Achievements;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ImplanAchievement;

class Table extends Component
{
    use WithPagination;

    public function statusUpdate($id)
    {
        $achievement = ImplanAchievement::find($id);
        if ($achievement->is_active == 1) {
            $achievement->is_active = 0;
        } else {
            $achievement->is_active = 1;
        }

        $achievement->save();

        session()->flash('success', 'Estado actualizado correctamente.');
    }

    public function render()
    {
        $achievements = ImplanAchievement::paginate(10);

        return view('implan.achievements.utilities.table', [
            'achievements' => $achievements
        ]);
    }
}
