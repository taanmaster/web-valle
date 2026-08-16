<?php

namespace App\Livewire\BlogCategories;

use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Livewire\Component;

class Manager extends Component
{
    public $editingId = null;

    public $name = '';

    public $is_active = true;

    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);

        $this->editingId = $category->id;
        $this->name = $category->name;
        $this->is_active = $category->is_active;
    }

    public function resetForm()
    {
        $this->reset(['editingId', 'name', 'is_active']);
        $this->is_active = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($this->editingId) {
            $category = BlogCategory::findOrFail($this->editingId);
            $category->update([
                'name' => $this->name,
                'is_active' => $this->is_active,
            ]);
        } else {
            BlogCategory::create([
                'name' => $this->name,
                'slug' => $this->uniqueSlug(Str::slug($this->name)),
                'is_active' => $this->is_active,
            ]);
        }

        $this->resetForm();
        session()->flash('success', 'Categoría guardada correctamente.');
    }

    public function delete($id)
    {
        BlogCategory::findOrFail($id)->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }
    }

    private function uniqueSlug(string $base): string
    {
        $slug = $base ?: 'categoria';
        $i = 1;

        while (BlogCategory::where('slug', $slug)->exists()) {
            $slug = $base.'-'.(++$i);
        }

        return $slug;
    }

    public function render()
    {
        return view('blog-categories.utilities.manager', [
            'categories' => BlogCategory::withCount('blogs')->orderBy('name')->get(),
        ]);
    }
}
