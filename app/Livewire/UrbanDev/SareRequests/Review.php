<?php

namespace App\Livewire\UrbanDev\SareRequests;

use App\Models\SareRequestReview;
use App\Models\SareRequestReviewPhoto;
use App\Models\UrbanDevWorker;
use Livewire\Component;
use Livewire\WithFileUploads;
use Session;
use Storage;

class Review extends Component
{
    use WithFileUploads;

    public SareRequestReview $review;

    // Inspección
    public $inspector_id = '';

    public $measured_area = '';

    public $observations = '';

    public $photos = [];

    // Emisión del permiso
    public $permit_document;

    // Entero de pago
    public $payment_amount = '';

    public $payment_reference = '';

    public $payment_document;

    public function mount(SareRequestReview $review)
    {
        $this->review = $review;

        $this->inspector_id = $review->inspector_id ?? '';
        $this->measured_area = $review->measured_area ?? '';
        $this->observations = $review->observations ?? '';

        $this->payment_amount = $review->payment_amount ?? '';
        $this->payment_reference = $review->payment_reference ?? '';
    }

    /**
     * Guarda la información de la inspección (inspector, superficie, observaciones y fotos).
     */
    public function saveInspection()
    {
        $this->validate([
            'inspector_id' => 'required|integer',
            'measured_area' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:2000',
            'photos.*' => 'nullable|image|max:10240', // 10 MB por foto
        ], [
            'inspector_id.required' => 'Debes seleccionar un inspector.',
        ]);

        $this->review->update([
            'inspector_id' => $this->inspector_id,
            'measured_area' => $this->measured_area ?: null,
            'observations' => $this->observations ?: null,
            'inspection_date' => now(),
        ]);

        foreach ($this->photos as $photo) {
            $filepath = 'sare_reviews/'.$this->review->id.'/photos/'.$this->cleanFilename($photo);

            $stream = fopen($photo->getRealPath(), 'r+');
            Storage::disk('s3')->put($filepath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            SareRequestReviewPhoto::create([
                'sare_request_review_id' => $this->review->id,
                'filename' => $photo->getClientOriginalName(),
                'filesize' => $photo->getSize(),
                's3_asset_url' => Storage::disk('s3')->url($filepath),
            ]);
        }

        $this->reset('photos');
        $this->refreshStatus();

        $this->review->refresh();

        Session::flash('success', 'Información de la inspección guardada correctamente.');
    }

    /**
     * Guarda el documento del permiso emitido.
     */
    public function savePermit()
    {
        $this->validate([
            'permit_document' => 'required|file|max:10240',
        ], [
            'permit_document.required' => 'Debes seleccionar el documento del permiso.',
        ]);

        $filepath = 'sare_reviews/'.$this->review->id.'/permit/'.$this->cleanFilename($this->permit_document);

        $stream = fopen($this->permit_document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        $this->review->permit_document_name = $this->permit_document->getClientOriginalName();
        $this->review->permit_document_s3_url = Storage::disk('s3')->url($filepath);
        $this->review->permit_document_size = $this->permit_document->getSize();
        $this->review->status = $this->review->refreshStatus();
        $this->review->save();

        $this->reset('permit_document');

        Session::flash('success', 'Permiso guardado correctamente.');
    }

    /**
     * Guarda el comprobante de entero de pago.
     */
    public function savePayment()
    {
        $this->validate([
            'payment_amount' => 'nullable|numeric|min:0',
            'payment_reference' => 'nullable|string|max:255',
            'payment_document' => 'required|file|max:10240',
        ], [
            'payment_document.required' => 'Debes seleccionar el comprobante de pago.',
        ]);

        $filepath = 'sare_reviews/'.$this->review->id.'/payment/'.$this->cleanFilename($this->payment_document);

        $stream = fopen($this->payment_document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        $this->review->payment_amount = $this->payment_amount !== '' ? $this->payment_amount : null;
        $this->review->payment_reference = $this->payment_reference ?: null;
        $this->review->payment_document_name = $this->payment_document->getClientOriginalName();
        $this->review->payment_document_s3_url = Storage::disk('s3')->url($filepath);
        $this->review->payment_document_size = $this->payment_document->getSize();
        $this->review->status = $this->review->refreshStatus();
        $this->review->save();

        $this->reset('payment_document');

        Session::flash('success', 'Entero de pago guardado correctamente.');
    }

    /**
     * Recalcula y persiste el estatus de la revisión.
     */
    private function refreshStatus(): void
    {
        $this->review->status = $this->review->refreshStatus();
        $this->review->save();
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
        $this->review->load(['sareRequest.user', 'sareRequest.files', 'inspector', 'photos']);

        return view('urban_dev.sare_requests.utilities.review', [
            'inspectors' => UrbanDevWorker::inspectors()->orderBy('name')->get(),
        ]);
    }
}
