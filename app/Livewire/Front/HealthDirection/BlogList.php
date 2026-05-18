<?php

namespace App\Livewire\Front\HealthDirection;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\HealthDirectionBlog;

class BlogList extends Component
{
    use WithPagination;

    public string $category = '';
    public string $published_date = '';

    public function resetFilters()
    {
        $this->published_date = '';
        $this->resetPage();
    }

    public function updatingPublishedDate(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = HealthDirectionBlog::query();

        if ($this->category !== '') {
            $query->where('category', $this->category);
        }

        if ($this->published_date !== '') {
            $query->whereDate('published_at', $this->published_date);
        }

        $blogs = $query->latest()->paginate(8);

        return view('front.health_direction.utilities.blog-list', [
            'blogs' => $blogs,
        ]);
    }
}
