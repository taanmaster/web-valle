<?php

namespace App\Livewire\ProteccionCivil\Requests;

use App\Models\UrbanDevRequestReview;
use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Session;
use Storage;

class Review extends Component
{
    use WithFileUploads;

    public UrbanDevRequestReview $review;

    public $resolution = '';

    public $reference_number = '';

    public $technical_notes = '';

    public $conditions_requirements = '';

    public $issued_by = '';

    public $resolution_document;

    public function mount(UrbanDevRequestReview $review)
    {
        $this->review = $review;

        $this->resolution = $review->resolution ?? '';
        $this->reference_number = $review->reference_number ?? '';
        $this->technical_notes = $review->technical_notes ?? '';
        $this->conditions_requirements = $review->conditions_requirements ?? '';
        $this->issued_by = $review->issued_by ?? '';
    }

    /**
     * Guarda la opinión técnica de Protección Civil. El oficio firmado es obligatorio
     * para poder dar por emitida la opinión.
     */
    public function saveOpinion()
    {
        $this->validate([
            'resolution' => 'required|in:factible,factible_con_condicionantes,no_factible',
            'reference_number' => 'nullable|string|max:255',
            'technical_notes' => 'required|string|max:2000',
            'conditions_requirements' => 'nullable|string|max:2000',
            'issued_by' => 'required|string|max:255',
            'resolution_document' => 'required|file|mimes:pdf|max:10240',
        ], [], [
            'resolution' => 'resolución',
            'technical_notes' => 'medidas preventivas y observaciones',
            'issued_by' => 'emite (nombre y cargo)',
            'resolution_document' => 'oficio de resolución firmado',
        ]);

        $filepath = 'urban_dev_reviews/'.$this->review->id.'/proteccion_civil/'.$this->cleanFilename($this->resolution_document);

        $stream = fopen($this->resolution_document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        $this->review->resolution = $this->resolution;
        $this->review->reference_number = $this->reference_number ?: null;
        $this->review->technical_notes = $this->technical_notes;
        $this->review->conditions_requirements = $this->conditions_requirements ?: null;
        $this->review->issued_by = $this->issued_by;
        $this->review->resolution_document_name = $this->resolution_document->getClientOriginalName();
        $this->review->resolution_document_s3_url = Storage::disk('s3')->url($filepath);
        $this->review->resolution_document_size = $this->resolution_document->getSize();
        $this->review->resolved_at = now();
        $this->review->resolved_by = Auth::id();
        $this->review->status = $this->review->refreshStatus();
        $this->review->save();

        $this->reset('resolution_document');

        Session::flash('success', 'Opinión técnica guardada correctamente.');
    }

    private function cleanFilename($file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);

        return $cleanName.'_'.time().'.'.$extension;
    }

    public function render()
    {
        $this->review->load(['urbanDevRequest.user', 'urbanDevRequest.castro']);

        return view('livewire.proteccion-civil.requests.review');
    }
}
