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

    protected $paginationTheme = 'bootstrap';

    public $bidding;

    public $mode = 0;

    #[On('proposalSaved')]
    public function refreshTable()
    {
        $this->dispatch('$refresh');
    }


    public function render()
    {
        $query = BiddingProposal::query();

        if ($this->mode == 3) {

            $supplierIds = Auth::user()->suppliers->pluck('id');

            $proposals = $query
                ->where('bidding_id', $this->bidding->id)
                ->whereIn('supplier_id', $supplierIds)
                ->paginate(8);
        } else {
            $proposals = $query->where('bidding_id', $this->bidding->id)->paginate(8);
        }



        return view('livewire.bidding.proposal.table', [
            'proposals' => $proposals
        ]);
    }
}
