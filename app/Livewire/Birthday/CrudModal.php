<?php

namespace App\Livewire\Birthday;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Birthday;

class CrudModal extends Component
{
    use WithFileUploads;

    public $birthdays;
    public bool $showModal = false;
    public ?int $birthdayId = null;

    public $month = '';
    public $photo = null;

    public function mount(): void
    {
        $this->loadBirthdays();
    }

    public function loadBirthdays(): void
    {
        $this->birthdays = Birthday::orderBy('month')->get();
    }

    public function openCreate(): void
    {
        $this->reset(['birthdayId', 'month', 'photo']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $birthday = Birthday::findOrFail($id);

        $this->birthdayId = $birthday->id;
        $this->month      = $birthday->month;
        $this->photo      = null;
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'month' => 'required|integer|between:1,12',
            'photo' => ($this->birthdayId ? 'nullable' : 'required') . '|image|max:15360',
        ], [
            'month.required' => 'Selecciona el mes.',
            'photo.required' => 'Carga la foto del mes.',
            'photo.image'    => 'El archivo debe ser una imagen.',
        ]);

        $existing = Birthday::where('month', $this->month)->first();

        $photoUrl = $existing?->photo;

        if ($this->photo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            // Reemplaza la foto anterior del mes (si la hay) en S3
            if ($existing?->photo) {
                $key = ltrim(parse_url($existing->photo, PHP_URL_PATH) ?? '', '/');
                if ($key !== '') {
                    Storage::disk('s3')->delete($key);
                }
            }
            $photoUrl = $this->handleUpload($this->photo);
        }

        // Un registro por mes: si el mes ya existe solo se actualiza la foto
        Birthday::updateOrCreate(
            ['month' => $this->month],
            ['photo' => $photoUrl]
        );

        $this->closeModal();
        $this->loadBirthdays();
        session()->flash('success', 'Foto del mes guardada correctamente.');
    }

    public function delete(int $id): void
    {
        $birthday = Birthday::findOrFail($id);

        if ($birthday->photo) {
            $key = ltrim(parse_url($birthday->photo, PHP_URL_PATH) ?? '', '/');
            if ($key !== '') {
                Storage::disk('s3')->delete($key);
            }
        }

        $birthday->delete();

        $this->loadBirthdays();
        session()->flash('success', 'Registro eliminado.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['birthdayId', 'month', 'photo']);
        $this->resetValidation();
    }

    protected function handleUpload($document): string
    {
        $extension = $document->getClientOriginalExtension();
        $filename  = 'birthday_' . time() . '_' . Str::random(10) . '.' . $extension;
        $filepath  = 'birthdays/' . $filename;

        $stream = fopen($document->getRealPath(), 'r+');
        Storage::disk('s3')->put($filepath, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }

        return Storage::disk('s3')->url($filepath);
    }

    public function render()
    {
        return view('livewire.birthday.crud-modal', [
            'monthNames' => Birthday::MONTHS,
        ]);
    }
}
