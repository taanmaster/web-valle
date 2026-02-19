<?php

namespace App\Exports;

use App\Models\AppointmentBooking;
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
use Carbon\Carbon;

class AppointmentBookingsExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles, ShouldAutoSize
{
    protected $appointmentId;
    protected $date;

    public function __construct($appointmentId, $date)
    {
        $this->appointmentId = $appointmentId;
        $this->date = $date;
    }

    public function collection()
    {
        return AppointmentBooking::with(['appointment.dependency', 'user'])
            ->where('appointment_id', $this->appointmentId)
            ->where('date', $this->date)
            ->orderBy('start_time', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Folio',
            'Nombre del Ciudadano',
            'Correo Electrónico',
            'Teléfono',
            'Trámite',
            'Dependencia',
            'Fecha',
            'Hora Inicio',
            'Hora Fin',
            'Estatus de Confirmación',
            'Estatus de Asistencia',
            'Notas',
        ];
    }

    public function map($booking): array
    {
        $statusLabels = [
            'scheduled' => 'Agendada',
            'confirmed' => 'Confirmada',
            'cancelled' => 'Cancelada',
        ];

        $attendanceLabels = [
            'attended' => 'Asistió',
            'not_attended' => 'No Asistió',
        ];

        return [
            $booking->folio,
            $booking->full_name,
            $booking->email,
            $booking->phone,
            $booking->appointment->name ?? 'N/A',
            $booking->appointment->dependency->name ?? 'N/A',
            Carbon::parse($booking->date)->format('d/m/Y'),
            Carbon::parse($booking->start_time)->format('H:i'),
            Carbon::parse($booking->end_time)->format('H:i'),
            $statusLabels[$booking->status] ?? $booking->status,
            $attendanceLabels[$booking->attendance_status] ?? 'Pendiente',
            $booking->notes ?: '',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 30,
            'D' => 15,
            'E' => 25,
            'F' => 25,
            'G' => 12,
            'H' => 12,
            'I' => 12,
            'J' => 20,
            'K' => 20,
            'L' => 40,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
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
