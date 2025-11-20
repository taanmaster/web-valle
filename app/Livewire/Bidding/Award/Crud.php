<?php

namespace App\Livewire\Bidding\Award;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//Models
use App\Models\Bidding;
use App\Models\BiddingProposal;
use App\Models\BiddingAward;

class Crud extends Component
{
    use WithFileUploads;

    public $bidding;
    public $award;
    public $proposal;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    public $description = '';
    public $file = '';

    public function mount()
    {
        $this->proposal = BiddingProposal::where('bidding_id', $this->bidding->id)->where('status', 'Adjudicada')->first();

        if ($this->bidding->award != null) {
            $this->award = BiddingAward::first();

            $this->fetchAward();
        }
    }

    public function fetchAward()
    {

        $this->description = $this->award->description;
        $this->file = $this->award->file;

    }

    public function updatedDescription()
    {
        if ($this->award != null) {
            $award = BiddingAward::findOrFail($this->award->id);
            $award->description = $this->description;

            $award->save();
        } else {

            $award = new BiddingAward;
            $award->bidding_id = $this->bidding->id;
            $award->proposal_id = $this->proposal->id;
            $award->description = $this->description;

            $award->save();

            $this->award = $award;
        }
    }

    public function updatedFile()
    {
        if (!$this->file) {
            return;
        }

        // Subimos el archivo a S3
        $fileUrl = $this->handleUpload($this->file);

        if ($this->award != null) {

            // Actualizar Award existente
            $award = BiddingAward::findOrFail($this->award->id);
            $award->file = $fileUrl;
            $award->save();
        } else {

            // Crear nuevo Award
            $award = new BiddingAward;
            $award->bidding_id = $this->bidding->id;
            $award->proposal_id = $this->proposal->id;
            $award->file = $fileUrl;
            $award->save();

            $this->award = $award;
        }
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'acquisitions/biddings/proposals/awards/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        return view('livewire.bidding.award.crud');
    }
}
