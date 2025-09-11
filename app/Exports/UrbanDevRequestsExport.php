<?php

namespace App\Exports;

use App\Models\UrbanDevRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class UrbanDevRequestsExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = UrbanDevRequest::with(['user', 'files', 'inspector']);

        // Aplicar los mismos filtros que en el controlador
        if (!empty($this->filters['fecha_inicio'])) {
            $query->whereDate('created_at', '>=', $this->filters['fecha_inicio']);
        }

        if (!empty($this->filters['fecha_fin'])) {
            $query->whereDate('created_at', '<=', $this->filters['fecha_fin']);
        }

        if (!empty($this->filters['folio'])) {
            $query->where(function($q) {
                $q->where('payment_ref_number_1', 'LIKE', '%' . $this->filters['folio'] . '%')
                  ->orWhere('payment_ref_number_2', 'LIKE', '%' . $this->filters['folio'] . '%')
                  ->orWhere('inspector_license_number', 'LIKE', '%' . $this->filters['folio'] . '%');
            });
        }

        if (!empty($this->filters['solicitante'])) {
            $query->whereHas('user', function($q) {
                $q->where('name', 'LIKE', '%' . $this->filters['solicitante'] . '%')
                  ->orWhere('email', 'LIKE', '%' . $this->filters['solicitante'] . '%');
            });
        }

        if (!empty($this->filters['estatus'])) {
            $query->where('status', $this->filters['estatus']);
        }

        if (!empty($this->filters['tipo_tramite'])) {
            $query->where('request_type', $this->filters['tipo_tramite']);
        }

        if (!empty($this->filters['inspector'])) {
            $query->where('inspector_id', $this->filters['inspector']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID',
            'Fecha de Solicitud',
            'Solicitante',
            'Email',
            'Tipo de Trámite',
            'Estatus',
            'Inspector Asignado',
            'Fecha de Entrega a Inspector',
            'Tipo de Edificación',
            'Fecha de Pago',
            'Monto de Pago',
            'Folio Desarrollo',
            'Folio Pagado',
            'Vigencia Inicio',
            'Vigencia Fin',
            'Número de Documentos',
            'Descripción'
        ];
    }

    /**
    * @param mixed $request
    * @return array
    */
    public function map($request): array
    {
        return [
            $request->id,
            $request->created_at->format('d/m/Y H:i'),
            $request->user->name ?? 'N/A',
            $request->user->email ?? 'N/A',
            $request->getRequestTypeLabelAttribute(),
            $request->getStatusLabelAttribute(),
            $request->inspector->name ?? 'No asignado',
            $request->inspection_start_date ? $request->inspection_start_date->format('d/m/Y') : 'N/A',
            $request->getBuildingTypeLabelAttribute() ?: 'N/A',
            $request->payment_date ? $request->payment_date->format('d/m/Y') : 'N/A',
            $request->payment_amount ? '$' . number_format($request->payment_amount, 2) : 'N/A',
            $request->payment_ref_number_1 ?: 'N/A',
            $request->payment_ref_number_2 ?: 'N/A',
            $request->inspection_validity_start ? $request->inspection_validity_start->format('d/m/Y') : 'N/A',
            $request->inspection_validity_end ? $request->inspection_validity_end->format('d/m/Y') : 'N/A',
            $request->files->count(),
            $request->description ?: 'Sin descripción'
        ];
    }

    /**
    * @return array
    */
    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 18,  // Fecha de Solicitud
            'C' => 25,  // Solicitante
            'D' => 30,  // Email
            'E' => 25,  // Tipo de Trámite
            'F' => 15,  // Estatus
            'G' => 25,  // Inspector
            'H' => 18,  // Fecha Entrega Inspector
            'I' => 20,  // Tipo Edificación
            'J' => 15,  // Fecha Pago
            'K' => 15,  // Monto
            'L' => 18,  // Folio Desarrollo
            'M' => 18,  // Folio Pagado
            'N' => 15,  // Vigencia Inicio
            'O' => 15,  // Vigencia Fin
            'P' => 12,  // Documentos
            'Q' => 40,  // Descripción
        ];
    }

    /**
    * @param Worksheet $sheet
    * @return array
    */
    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para los encabezados
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '495057'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}
