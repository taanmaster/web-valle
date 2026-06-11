<?php

namespace App\Livewire\Benefits;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

use App\Models\Benefit;

class EntriesTable extends Component
{
    use WithPagination;

    public bool $show_filters = false;

    public $filter_fecha  = '';
    public $filter_titulo = '';

    public function toggleFilters(): void
    {
        $this->show_filters = !$this->show_filters;
    }

    public function resetFilters(): void
    {
        $this->reset(['filter_fecha', 'filter_titulo']);
        $this->resetPage();
    }

    public function updatedFilterFecha(): void
    {
        $this->resetPage();
    }

    public function updatedFilterTitulo(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $entry = Benefit::with('images')->find($id);
        if (!$entry) {
            return;
        }

        if ($entry->hero_img) {
            $this->deleteFromS3($entry->hero_img);
        }

        foreach ($entry->images as $image) {
            $this->deleteFromS3($image->image_path);
        }

        $entry->delete();

        session()->flash('success', 'Beneficio eliminado correctamente.');
    }

    private function deleteFromS3(string $url): void
    {
        $key = ltrim(parse_url($url, PHP_URL_PATH) ?? '', '/');
        if ($key !== '') {
            Storage::disk('s3')->delete($key);
        }
    }

    public function render()
    {
        $query = Benefit::query();

        if ($this->filter_fecha) {
            $query->whereDate('published_at', $this->filter_fecha);
        }

        if ($this->filter_titulo) {
            $query->where('title', 'like', '%' . $this->filter_titulo . '%');
        }

        return view('benefits.utilities.entries-table', [
            'entries' => $query->orderByDesc('published_at')->orderByDesc('id')->paginate(8),
        ]);
    }
}
