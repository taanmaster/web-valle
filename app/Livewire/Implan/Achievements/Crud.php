<?php

namespace App\Livewire\Implan\Achievements;

// Ayudantes
use Str;
use Auth;
use Session;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Intervention\Image\Facades\Image as Image;
use Livewire\WithFileUploads;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Models\ImplanAchievement;
use Livewire\Component;

class Crud extends Component
{
    use WithFileUploads;

    public $achievement;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    public $title = '';
    public $description = '';
    public $hex = '';
    public $image;
    public $file;
    public $published_at;
    public $is_active = true;

    public function mount()
    {
        if ($this->achievement != null) {
            $this->fetchAchievementData();
        }
    }

    public function fetchAchievementData()
    {
        $this->title = $this->achievement->title;
        $this->description = $this->achievement->description;
        $this->image = $this->achievement->image;
        $this->file = $this->achievement->file;
        $this->hex = $this->achievement->hex;
        $this->published_at = $this->achievement->published_at ? Carbon::parse($this->achievement->published_at)->format('Y-m-d') : null;
        $this->is_active = $this->achievement->is_active;
    }

    public function save()
    {
        if ($this->achievement != null) {

            $record = ImplanAchievement::find($this->achievement->id);

            $record->title = $this->title;
            $record->description = $this->description;
            $record->hex = $this->hex;
            $record->published_at = $this->published_at;
            $record->is_active = $this->is_active;

            $record->save();
        } else {
            $record = new ImplanAchievement;
            $record->title = $this->title;
            $record->description = $this->description;
            $record->hex = $this->hex;
            $record->published_at = $this->published_at;
            $record->is_active = $this->is_active;

            $record->save();
        }

        return redirect()->route('implan.achievements.show', $record->id);
    }

    public function render()
    {
        return view('implan.achievements.utilities.crud');
    }
}
