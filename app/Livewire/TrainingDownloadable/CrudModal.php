<?php

namespace App\Livewire\TrainingDownloadable;

use Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\TrainingDownloadable;

class CrudModal extends Component
{
    use WithFileUploads;

    public $items;
    public bool $showModal = false;
    public ?int $itemId = null;

    public string $title = '';
    public $document = '';

    public function mount(): void
    {
        $this->loadItems();
    }

    public function loadItems(): void
    {
        $this->items = TrainingDownloadable::latest()->get();
    }

    public function openCreate(): void
    {
        $this->reset(['itemId', 'title', 'document']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $item = TrainingDownloadable::findOrFail($id);
        $this->itemId   = $item->id;
        $this->title    = $item->title;
        $this->document = '';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'title'    => 'required|string|max:255',
            'document' => $this->itemId ? 'nullable|file|mimes:pdf' : 'required|file|mimes:pdf',
        ]);

        if ($this->itemId) {
            $item = TrainingDownloadable::findOrFail($this->itemId);

            $document_url = $this->document
                ? $this->handleUpload($this->document)
                : $item->document_url;

            $item->update([
                'title'        => $this->title,
                'document_url' => $document_url,
            ]);
        } else {
            TrainingDownloadable::create([
                'title'        => $this->title,
                'document_url' => $this->handleUpload($this->document),
            ]);
        }

        $this->closeModal();
        $this->loadItems();
        session()->flash('success', 'Registro guardado correctamente.');
    }

    public function delete(int $id): void
    {
        TrainingDownloadable::findOrFail($id)->delete();
        $this->loadItems();
        session()->flash('success', 'Registro eliminado.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['itemId', 'title', 'document']);
        $this->resetValidation();
    }

    protected function handleUpload($document)
    {
        $originalName = pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
        $extension    = $document->getClientOriginalExtension();

        $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $originalName);
        $filename  = $cleanName . '.' . $extension;

        $filepath = 'training/downloadables/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        return view('livewire.training-downloadable.crud-modal');
    }
}
