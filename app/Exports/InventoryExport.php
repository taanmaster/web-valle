<?php

namespace App\Exports;

use App\Models\AcquisitionMaterial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class InventoryExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function collection()
    {
        return AcquisitionMaterial::select(
            'sku',
            'title',
            'dependency_name',
            'current_stock'
        )->get();
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Nombre',
            'Dependencia',
            'Cantidad Disponible',
        ];
    }

    public function map($row): array
    {
        return [
            $row->sku,
            $row->title,
            $row->dependency_name,
            $row->current_stock,
        ];
    }
}
