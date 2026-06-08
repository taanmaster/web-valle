<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TsrAccountDueDailyReportExport implements FromCollection, WithHeadings, WithMapping
{
    private Collection $receipts;

    public function __construct(Collection $receipts)
    {
        $this->receipts = $receipts;
    }

    public function collection(): Collection
    {
        return $this->receipts;
    }

    public function headings(): array
    {
        return [
            'Recibo',
            'Fecha y hora',
            'Contribuyente',
            'Dependencia',
            'Concepto',
            'Caja',
            'Cajero',
            'Efectivo',
            'Tarjeta',
            'Cheque',
            'Transferencia',
            'Total',
        ];
    }

    public function map($receipt): array
    {
        return [
            $receipt->id,
            optional($receipt->created_at)->format('d/m/Y H:i'),
            optional($receipt->income)->name,
            optional($receipt->income)->department,
            optional($receipt->income)->concept,
            $receipt->cashier,
            $receipt->cashier_user,
            (float) ($receipt->total_cash ?? 0),
            (float) ($receipt->total_card ?? 0),
            (float) ($receipt->total_check ?? 0),
            (float) ($receipt->total_transfer ?? 0),
            (float) ($receipt->total ?? 0),
        ];
    }
}
