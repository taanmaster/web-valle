<?php

namespace App\Livewire\Birthday;

use Livewire\Component;
use App\Models\Birthday;

class CrudModal extends Component
{
    public $birthdays;
    public bool $showModal = false;
    public ?int $birthdayId = null;
    public string $name = '';
    public string $area = '';
    public string $birthday_date = '';

    public function mount(): void
    {
        $this->loadBirthdays();
    }

    public function loadBirthdays(): void
    {
        $this->birthdays = Birthday::orderBy('birthday_date')->get();
    }

    public function openCreate(): void
    {
        $this->reset(['birthdayId', 'name', 'area', 'birthday_date']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $birthday = Birthday::findOrFail($id);
        $this->birthdayId     = $birthday->id;
        $this->name           = $birthday->name;
        $this->area           = $birthday->area;
        $this->birthday_date  = $birthday->birthday_date->format('Y-m-d');
        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate([
            'name'          => 'required|string|max:255',
            'area'          => 'required|string|max:255',
            'birthday_date' => 'required|date',
        ]);

        $data = [
            'name'          => $this->name,
            'area'          => $this->area,
            'birthday_date' => $this->birthday_date,
        ];

        if ($this->birthdayId) {
            Birthday::findOrFail($this->birthdayId)->update($data);
        } else {
            Birthday::create($data);
        }

        $this->closeModal();
        $this->loadBirthdays();
        session()->flash('success', 'Cumpleaños guardado correctamente.');
    }

    public function delete(int $id): void
    {
        Birthday::findOrFail($id)->delete();
        $this->loadBirthdays();
        session()->flash('success', 'Registro eliminado.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['birthdayId', 'name', 'area', 'birthday_date']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.birthday.crud-modal');
    }
}
