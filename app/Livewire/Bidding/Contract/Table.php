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
use Livewire\WithPagination;

//Models
use App\Models\Bidding;
use App\Models\BiddingProposal;
use App\Models\BiddingAward;
use App\Models\BiddingContract;
use App\Models\BiddingDeliverable;

class Table extends Component
{
    use WithPagination;

    public $bidding;
    public $award;
    public $proposal;

    #[On('closeModalContract')]
    public function refreshTable()
    {
        $this->dispatch('$refresh');
    }

    #[On('checklistDone')]
    public function refreshCheck()
    {
        $this->dispatch('$refresh');
    }

    public function deleteCheck($id)
    {
        $checklist = BiddingDeliverable::findOrFail($id);
        $checklist->delete();
    }

    public function render()
    {
        $query = BiddingContract::query();

        $contracts = $query->where('bidding_id', $this->bidding->id)->get();

        return view('livewire.bidding.contract.table', [
            'contracts' => $contracts
        ]);
    }
}
