<?php

namespace App\Livewire\Ayuda;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\GuiaCategoria;

class CategorySelector extends Component
{
    public $selectedId = null;
    public $search = '';
    public bool $isOpen = false;
    public int $mode = 0;

    public function mount($selectedId = null, int $mode = 0): void
    {
        $this->selectedId = $selectedId;
        $this->mode = $mode;
    }

    public function toggle(): void
    {
        if ($this->mode === 1) return;
        $this->isOpen = !$this->isOpen;
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->search = '';
    }

    public function select(int $id): void
    {
        $this->selectedId = $id;
        $this->dispatch('categorySelected', id: $id);
        $this->close();
    }

    public function deselect(): void
    {
        $this->selectedId = null;
        $this->dispatch('categorySelected', id: null);
    }

    public function createCategory(): void
    {
        $name = trim($this->search);
        if ($name === '') return;

        $cat = GuiaCategoria::firstOrCreate(['nombre' => $name]);
        $this->select($cat->id);
    }

    public function deleteCategory(int $id): void
    {
        $cat = GuiaCategoria::withCount('guias')->findOrFail($id);

        if ($cat->guias_count > 0) {
            $this->dispatch('notify', type: 'error', message: "No se puede eliminar: la categoría tiene {$cat->guias_count} guía(s) relacionada(s).");
            return;
        }

        $cat->delete();

        if ($this->selectedId == $id) {
            $this->selectedId = null;
            $this->dispatch('categorySelected', id: null);
        }
    }

    public function render()
    {
        $categories = GuiaCategoria::withCount('guias')
            ->when($this->search, fn($q) => $q->where('nombre', 'like', '%' . $this->search . '%'))
            ->orderBy('nombre')
            ->get();

        $selected = $this->selectedId
            ? GuiaCategoria::find($this->selectedId)
            : null;

        return view('ayuda.utilities.category-selector', [
            'categories' => $categories,
            'selected'   => $selected,
        ]);
    }
}
