<?php

namespace App\Livewire\Implan\Projects;

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

use App\Models\ImplanProject;
use Livewire\Component;

class Crud extends Component
{
    use WithFileUploads;

    public $project;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    public $title = '';
    public $slug = '';
    public $image;
    public $type = '';
    public $description = '';
    public $file;
    public $published_at;
    public $is_active = true;

    public function mount()
    {
        if ($this->project != null) {
            $this->fetchProjectData();
        }
    }

    public function fetchProjectData()
    {
        $this->title = $this->project->title;
        $this->slug = $this->project->slug;
        $this->description = $this->project->description;
        $this->published_at = $this->project->published_at ? Carbon::parse($this->project->published_at)->format('Y-m-d') : null;
        $this->is_active = $this->project->is_active;
    }

    public function save()
    {
        if ($this->project != null) {
            $this->project->update([
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'published_at' => $this->published_at,
                'is_active' => $this->is_active,
            ]);
        } else {
            ImplanProject::create([
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'published_at' => $this->published_at,
                'is_active' => $this->is_active,
            ]);
        }
    }

    public function render()
    {
        return view('implan.projects.utilities.crud');
    }
}
