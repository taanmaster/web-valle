<?php

namespace App\Exports;

use App\Models\AcquisitionInventoryMovementItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class IncomeInventoryExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function collection()
    {
        return AcquisitionInventoryMovementItem::with(['movement.supplier', 'material'])
            ->whereHas('movement', function ($query) {
                $query->where('type', 'Entrada');
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tipo',
            'SKU',
            'Nombre',
            'Dependencia',
            'Proveedor',
            'Cantidad Ingresada',
        ];
    }

    public function map($row): array
    {
        return [
            optional($row->movement)->type,
            optional($row->material)->sku,
            optional($row->material)->title,
            optional($row->movement)->dependency_name,
            optional($row->movement->supplier)->owner_name ?? 'N/A',
            $row->quantity,
        ];
    }
}
