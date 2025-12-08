<?php

namespace App\Exports;

use App\Models\AcquisitionInventoryMovement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class IncomeInventoryExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function collection()
    {
        return AcquisitionInventoryMovement::with(['material', 'supplier'])
            ->where('type', 'Entrada')
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
            $row->type,
            $row->sku,
            $row->title,
            $row->dependency_name,
            optional($row->supplier)->owner_name ?? 'N/A',
            $row->quantity,
        ];
    }
}
