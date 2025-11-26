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
    public $mode = 0;

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
        $this->title = $this->material->title;
        $this->description = $this->material->description;
        $this->sku = $this->material->sku;
        $this->dependency_name = $this->material->dependency_name;
        $this->is_active = $this->material->is_active;
        $this->category = $this->material->category;
        $this->current_stock = $this->material->current_stock;
    }

    public function save()
    {
        if ($this->material != null) {

            $material = AcquisitionMaterial::findOrFail($this->material->id);

            $material->title = $this->title;
            $material->description = $this->description;
            $material->is_active = $this->is_active;
            $material->category = $this->category;
            $material->dependency_name = $this->dependency_name;

            $material->save();

            Session::flash('success', 'El material se actualizo correctamente.');
        } else {

            $material = new AcquisitionMaterial;

            $material->sku = 'MAT-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4));

            $material->title = $this->title;
            $material->description = $this->description;
            $material->category = $this->category;
            $material->dependency_name = $this->dependency_name;

            $material->save();

            $this->material = $material;

            Session::flash('success', 'El material se creo correctamente.');
        }



        return redirect()->route('acquisitions.materials.show', $this->material->id);

    }

    public function render()
    {
        return view('acquisitions.materials.utilities.crud');
    }
}
