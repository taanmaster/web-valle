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
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

//Models
use App\Models\Bidding;
use App\Models\BiddingProposal;

class Dictum extends Component
{
    use WithFileUploads;

    public $proposal;

    //Campos
    public $status = '';
    public $dictum_file_name = '';
    public $dictum_file = '';


    public function save()
    {
        // Validación Livewire 3.x
        $this->validate([
            'status' => 'required|string',
            'dictum_file_name' => 'required|string|max:255',
            'dictum_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB
        ]);

        $proposal = BiddingProposal::findOrFail($this->proposal->id);

        $proposal->status = $this->status;
        $proposal->status_update = now()->format('Y-m-d');
        $proposal->dictum_file_name = $this->dictum_file_name;

        // --- Requirement File ---//
        $proposal->dictum_file = $this->dictum_file
            ? $this->handleUpload($this->dictum_file)
            : $proposal->dictum_file;

        $proposal->save();

        /**
         *  Si esta propuesta se adjudicó
         * Cambiar todas las demás propuestas del mismo bidding_id a “Fallo”
         */
        if ($proposal->status === 'Adjudicada') {
            BiddingProposal::where('bidding_id', $proposal->bidding_id)
                ->where('id', '!=', $proposal->id)
                ->update([
                    'status' => 'Fallo',
                    'status_update' => now()->format('Y-m-d'),
                ]);
        }

        $proposal->bidding->updateStatus();
        // Emitir evento global
        $this->dispatch('proposalSaved', id: $this->proposal->bidding_id);
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename = $cleanName . '.' . $extension;

        $filepath = 'acquisitions/biddings/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function clearModal()
    {
        $this->status = '';
        $this->dictum_file_name = '';
        $this->dictum_file = '';
    }

    public function render()
    {
        return view('livewire.bidding.proposal.dictum');
    }
}
