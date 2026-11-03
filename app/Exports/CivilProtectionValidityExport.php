<?php

namespace App\Exports;

use App\Livewire\ProteccionCivil\Validity\Table;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CivilProtectionValidityExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(protected ?string $status = null, protected ?string $search = null)
    {
    }

    public function collection()
    {
        $cases = Table::issuedCases($this->search ?? '');

        return $this->status ? $cases->where('validity_status', $this->status) : $cases;
    }

    public function headings(): array
    {
        return ['Consec.', 'Empresa / Ciudadano', 'No. de opinión / permiso', 'Expediente', 'Trámite', 'Emisión', 'Caducidad', 'Días restantes', 'Estatus'];
    }

    public function map($case): array
    {
        return [
            $case->document_consecutive,
            $case->applicant_name,
            $case->document_number,
            $case->folio,
            $case->procedure->name,
            $case->issued_at->format('d/m/Y'),
            $case->expires_at->format('d/m/Y'),
            $case->remaining_days,
            ['vigente' => 'Vigente', 'por_vencer' => 'Por vencer', 'vencida' => 'Vencida'][$case->validity_status],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
