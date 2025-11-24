<?php

namespace App\Livewire\Acquisitions\Materials;

use Livewire\Component;

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

use App\Models\AcquisitionMaterial;
use App\Models\RegulatoryAgendaDependency;
class Crud extends Component
{
    use WithFileUploads;

    public $material;

    //Modes: 0: create, 1 show, 2 edit
    public $mode;

    public $sku = '';
    public $title = '';
    public $is_active = '';

    public $description = '';
    public $category = '';
    public $dependency_name = '';
    public $current_stock = '';

    public $dependencies = [];

    public function mount()
    {
        $this->dependencies = RegulatoryAgendaDependency::get();

        if ($this->material != null) {
            $this->fetchMaterialData();
        }
    }

    public function fetchMaterialData()
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
        if ($this->material != null) {


            Session::flash('success', 'El material se actualizo correctamente.');
        } else {

            Session::flash('success', 'El material se creo correctamente.');
        }



        return redirect()->route('acquisitions.materials.show', $this->material->id);

    }

    public function render()
    {
        return view('acquisitions.materials.utilities.crud');
    }
}
