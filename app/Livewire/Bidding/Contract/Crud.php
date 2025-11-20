<?php

namespace App\Livewire\Bidding\Contract;

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
use App\Models\BiddingContract;

class Crud extends Component
{
    use WithFileUploads;

    public $bidding;
    public $contract;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    public $type = '';
    public $start_date = '';
    public $end_date = '';
    public $file_name = '';
    public $file = '';

    public function mount()
    {
        if ($this->contract != null) {
            $this->fetchContract();
        }
    }

    public function fetchContract()
    {
        $this->type = $this->contract->type;
        $this->start_date = $this->contract->start_date;
        $this->end_date = $this->contract->end_date;
        $this->file_name = $this->contract->file_name;
        $this->file = $this->contract->file;
    }

    public function save ()
    {
        if ($this->contract != null) {

            $contract = BiddingContract::findOrFail($this->contract->id);

            $contract->type = $this->type;
            $contract->start_date = $this->start_date;
            $contract->end_date = $this->end_date;
            $contract->file_name = $this->file_name;

            // --- Request File ---
            $contract->file = $this->file
                ? $this->handleUpload($this->file)
                : $contract->file;

            $contract->save();

            Session::flash('message', 'Contrato creado correctamente.');
        } else {

            $contract = new BiddingContract;

            $contract->bidding_id = $this->bidding->id;
            $contract->type = $this->type;
            $contract->start_date = $this->start_date;
            $contract->end_date = $this->end_date;
            $contract->file_name = $this->file_name;

            // --- Request File ---
            $contract->file = $this->file
                ? $this->handleUpload($this->file)
                : $contract->file;

            $contract->save();

            Session::flash('message', 'Contrato actualizado correctamente.');
        }

        $contract->bidding->updateStatus();

        $this->dispatch('closeModalContract');

        return redirect()->route('acquisitions.biddings.show', $contract->bidding->id);
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'acquisitions/biddings/proposals/contracts/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    #[On('closeModalContract')]
    public function clearModal()
    {
        $this->type = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->file_name = '';
        $this->file = '';
    }

    public function render()
    {
        return view('livewire.bidding.contract.crud');
    }
}
