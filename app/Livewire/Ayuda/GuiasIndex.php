<?php

namespace App\Livewire\Ayuda;

use Livewire\Component;
use App\Models\Guia;
use App\Models\GuiaCategoria;
use App\Models\TransparencyDependency;

class GuiasIndex extends Component
{
    public string $context = 'front'; // 'front' or 'admin'
    public $filter_dependencia = '';
    public $filter_titulo = '';
    public $filter_categoria = '';

    public function mount(string $context = 'front'): void
    {
        $this->context = $context;
    }

    public function setCategoria($id): void
    {
        $this->filter_categoria = ($this->filter_categoria == $id) ? '' : $id;
    }

    public function render()
    {
        $contextField = $this->context === 'front' ? 'mostrar_front' : 'mostrar_admin';

        $base = Guia::with('categoria')
            ->where($contextField, true)
            ->when($this->filter_dependencia, fn($q) => $q->where('dependencia', 'like', '%' . $this->filter_dependencia . '%'))
            ->when($this->filter_titulo, fn($q) => $q->where('titulo', 'like', '%' . $this->filter_titulo . '%'))
            ->when($this->filter_categoria, fn($q) => $q->where('guia_categoria_id', $this->filter_categoria));

        $destacadas = (clone $base)->where('destacada', true)->latest()->take(4)->get();
        $recientes  = (clone $base)->latest()->take(8)->get();

        return view('ayuda.utilities.guias-index', [
            'destacadas'   => $destacadas,
            'recientes'    => $recientes,
            'categorias'   => GuiaCategoria::orderBy('nombre')->get(),
            'dependencias' => TransparencyDependency::orderBy('name')->get(),
        ]);
    }
}
