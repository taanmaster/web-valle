<?php

namespace App\Livewire\Bidding\Proposal;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Storage;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

//Modelo
use App\Models\Bidding;
use App\Models\BiddingProposal;

class Table extends Component
{
    use WithPagination;

    public $bidding;


    #[On('proposalSaved')]
    public function refreshTable()
    {
        $this->render();
    }

    public function mount()
    {

    }


    public function render()
    {
        $query = BiddingProposal::query();

        $proposals = $query->where('bidding_id', $this->bidding->id)->paginate(4);

        return view('livewire.bidding.proposal.table', [
            'proposals' => $proposals
        ]);
    }
}
