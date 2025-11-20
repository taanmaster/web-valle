<?php

namespace App\Livewire\Front\CitizenComplain;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Intervention\Image\Facades\Image as Image;
use Livewire\WithFileUploads;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use App\Models\CitizenComplain;

class Show extends Component
{
    public $complain = '';

    public $id = '';
    public $subject = '';
    public $status = '';

    public function updatedComplain()
    {
        $complain = CitizenComplain::where('id', 'like', '%' . $this->complain . '%',)->first();

        $this->id = $complain->id;
        $this->subject = $complain->subject;
        $this->status = $complain->status;
    }

    public function render()
    {
        return view('front.citizen_complain.utilities.show');
    }
}
