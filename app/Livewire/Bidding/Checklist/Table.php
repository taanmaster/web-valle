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
    use WithFileUploads;

    public $bidding;

    public $files = [];
    public $checklist_id = '';

    #[On('refresh-checklist')]
    public function refreshMe()
    {
        $this->dispatch('$refresh'); // Fuerza refresh real del componente
    }

    public function save($id)
    {
        $item = BiddingDeliverable::findOrFail($id);

        // si existe archivo, subirlo
        if (isset($this->files[$id]) && $this->files[$id]) {

            $uploaded = $this->handleUpload($this->files[$id]);

            $item->upload_date = now()->format('Y-m-d');
        }

        $item->save();

        $item->bidding->updateStatus();

        $this->dispatch($refresh);
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'acquisitions/biddings/cotracts/checklists/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        $query = BiddingContract::query();

        $contracts = $query->where('bidding_id', $this->bidding->id)->get();

        return view('livewire.bidding.checklist.table', [
            'contracts' => $contracts
        ]);
    }
}
