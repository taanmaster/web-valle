<?php

namespace App\Exports;

use App\Models\AcquisitionInventoryMovement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class OutcomeInventoryExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function collection()
    {
        return AcquisitionInventoryMovement::with(['material', 'supplier'])
            ->where('type', 'Salida')
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
            'Cantidad Retirada',
        ];
    }

    public function map($row): array
    {
        return [
            $row->type,
            $row->sku,
            $row->title,
            $row->dependency_name,
            optional($row->supplier)->owner_name ?? 'N/A',
            $row->quantity,
        ];
    }
}
