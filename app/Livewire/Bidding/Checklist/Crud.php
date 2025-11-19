<?php

namespace App\Livewire\Bidding\Checklist;

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
use App\Models\BiddingDeliverable;

class Crud extends Component
{
    use WithFileUploads;

    public $bidding;
    public $contract;
    public $checklist;

    //Modes: 0: create, 1 show, 2 edit
    public $mode = 0;

    public $file_name = '';
    public $due_date = '';

    #[On('selectCheck')]
    public function showModal($id)
    {
        $this->checklist = BiddingDeliverable::findOrFail($id);

        $this->file_name = $this->checklist->file_name;
        $this->due_date = $this->checklist->due_date;
    }

    #[On('newCheckModal')]
    public function new($id)
    {
        $this->contract = BiddingContract::findOrFail($id);

        $this->file_name = '';
        $this->due_date = '';
    }

    public function save()
    {
        if ($this->checklist != null) {

            $checklist = BiddingDeliverable::findOrFail($this->checklist->id);

            $checklist->file_name = $this->file_name;
            $checklist->due_date = $this->due_date;

            $checklist->save();

        } else {

            $checklist = new BiddingDeliverable;
            $checklist->bidding_id = $this->bidding->id;
            $checklist->contract_id = $this->contract->id;

            $checklist->file_name = $this->file_name;
            $checklist->due_date = $this->due_date;

            $checklist->save();

            $checklist->bidding->updateStatus();
        }

        $this->dispatch('checklistDone');
    }

    #[On('checklistDone')]
    public function clearModalCheck()
    {
        $this->file_name = '';
        $this->due_date = '';
    }

    public function render()
    {
        return view('livewire.bidding.checklist.crud');
    }
}
