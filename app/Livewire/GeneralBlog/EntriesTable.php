<?php

namespace App\Livewire\GeneralBlog;

use App\Models\BlogCategory;
use App\Models\GeneralBlog;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class EntriesTable extends Component
{
    use WithPagination;

    // welfare | training | events | medio_ambiente
    public string $type;

    public $published_date = '';

    public $title = '';

    public $blog_category_id = '';

    public function resetFilters()
    {
        $this->reset(['published_date', 'title', 'blog_category_id']);
    }

    public function updating($property)
    {
        if (in_array($property, ['published_date', 'title', 'blog_category_id'])) {
            $this->resetPage();
        }
    }

    public function deleteEntry($id)
    {
        $entry = GeneralBlog::where('type', $this->type)->findOrFail($id);

        foreach ($entry->images as $image) {
            $key = ltrim(parse_url($image->image_path, PHP_URL_PATH), '/');
            Storage::disk('s3')->delete($key);
            $image->delete();
        }

        if ($entry->hero_img) {
            Storage::disk('s3')->delete(ltrim(parse_url($entry->hero_img, PHP_URL_PATH), '/'));
        }

        $entry->delete();

        session()->flash('success', 'Entrada eliminada correctamente.');
    }

    public function render()
    {
        $query = GeneralBlog::where('type', $this->type);

        if ($this->published_date) {
            $query->whereDate('published_at', $this->published_date);
        }

        if ($this->title !== '') {
            $query->where('title', 'like', '%'.$this->title.'%');
        }

        if ($this->blog_category_id !== '') {
            $query->where('blog_category_id', $this->blog_category_id);
        }

        $routePrefix = $this->type.'_blog';

        return view('general-blog.utilities.entries-table', [
            'entries' => $query->latest()->paginate(8),
            'routePrefix' => $routePrefix,
            'categories' => BlogCategory::where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
