<?php

namespace App\Livewire\Front\TransparencyObligations;

use Livewire\Component;

// Ayudantes
use Str;
use Auth;
use Session;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithPagination;

//Modelos
use App\Models\TransparencyObligation;
use App\Models\TransparencyDocument;

/**
 * Componente Livewire para mostrar y filtrar documentos de transparencia
 * 
 * FUNCIONALIDAD:
 * - Filtrado dinámico de documentos por año, período y obligación
 * - Ordenamiento automático de documentos por año (más reciente primero) y período (descendente)
 * - Integración con DataTables para ordenamiento en tiempo real del lado del cliente
 * 
 * MODOS DE OPERACIÓN:
 * - Mode 0: Normal - muestra obligaciones por tipo
 * - Mode 1: Filtrado por obligación específica
 * - Mode 2: Sin filtro de tipo
 * 
 * ORDENAMIENTO:
 * Backend (SQL): Los documentos se ordenan primero por año DESC, luego por período DESC
 * Frontend (DataTables): Permite reordenar por cualquier columna en tiempo real
 * 
 * @package App\Livewire\Front\TransparencyObligations
 */
class Table extends Component
{
    use WithPagination;

    //Mode: 0 normal, 1 Filtrado por obligación, 2 Sin tipo
    public $mode;

    public $dependency;
    public $type;

    public $transparency_obligation;

    public $period = '';
    public $year = '';
    public $selectedObligation = '';

    public $years = ['2028', '2027', '2026', '2025', '2024', '2023', '2022', '2021', '2020', '2019', '2018', '2017', '2016', '2015'];

    public function mount()
    {
    }

    public function resetFilters()
    {
        $this->period = '';
        $this->year = '';

        if ($this->mode != 1) {
            $this->selectedObligation = '';
        }
    }

    /**
     * Renderiza el componente con los documentos filtrados y ordenados
     * 
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Obtener obligaciones según el modo de operación
        if ($this->mode == 2) {
            $obligations = TransparencyObligation::where('dependency_id', $this->dependency)->get();
        } else {
            $obligations = TransparencyObligation::where('dependency_id', $this->dependency)->where('type', $this->type)->get();
        }

        // Construir query con filtros aplicados
        $query = TransparencyDocument::query();

        if ($this->period) {
            $query->where('period', $this->period);
        }
        if ($this->year !== '') {
            $query->where('year', $this->year);
        }
        if ($this->selectedObligation) {
            $query->where('obligation_id', $this->selectedObligation);
        }

        // Ordenar por año (más reciente primero) y luego por periodo (descendente)
        // Esto asegura que los documentos más recientes aparezcan al inicio de la tabla
        $documents = $query->orderBy('year', 'desc')
                          ->orderBy('period', 'desc')
                          ->get();

        return view('front.dependencies.utilities.table', [
            'documents' => $documents,
            'obligations' => $obligations,
        ]);
    }
}
