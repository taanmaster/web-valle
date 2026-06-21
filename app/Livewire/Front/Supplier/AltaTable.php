<?php

namespace App\Livewire\Front\Supplier;

use App\Models\OrderItem;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Componente Livewire para el listado de altas del proveedor con filtros en tiempo real.
 *
 * Reemplaza el formulario GET de la vista por filtrado reactivo (estado, tipo de
 * persona y búsqueda) manteniendo el mismo estilo y la misma tabla.
 *
 * @package App\Livewire\Front\Supplier
 */
class AltaTable extends Component
{
    use WithPagination;

    #[Url(as: 'status', except: '')]
    public string $status = '';

    #[Url(as: 'person_type', except: '')]
    public string $person_type = '';

    #[Url(as: 'search', except: '')]
    public string $search = '';

    /**
     * Al cambiar cualquier filtro, regresamos a la primera página.
     */
    public function updating(string $name)
    {
        if (in_array($name, ['status', 'person_type', 'search'])) {
            $this->resetPage();
        }
    }

    /**
     * Limpia todos los filtros.
     */
    public function clearFilters()
    {
        $this->reset(['status', 'person_type', 'search']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Supplier::where('user_id', Auth::id())
            ->with('files')
            ->orderBy('created_at', 'desc');

        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        if ($this->person_type !== '') {
            $query->where('person_type', $this->person_type);
        }

        if ($this->search !== '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('legal_name', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate(10);

        // Altas que ya tienen un pago en línea liquidado → se les oculta "Agregar a carrito"
        $paidSupplierIds = OrderItem::where('related_model_type', Supplier::class)
            ->whereIn('related_model_id', $suppliers->pluck('id'))
            ->whereHas('order', fn ($q) => $q->where('payment_status', 'Pagado'))
            ->pluck('related_model_id')
            ->all();

        return view('livewire.front.supplier.alta-table', compact('suppliers', 'paidSupplierIds'));
    }
}
