<?php

namespace App\Imports;

use App\Models\UrbanDevWorker;
use Carbon\Carbon;

// Importación por medio de Colección
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UrbanDevWorkerImport implements ToCollection, WithHeadingRow
{
    protected $dependencyCategory;

    public function __construct($dependencyCategory)
    {
        $this->dependencyCategory = $dependencyCategory;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $employee_number = $row['employee_number'];
            $name = $row['name'];
            $last_name = $row['last_name'];
            $issue_date = $row['issue_date'];
            $validity_date_start = $row['validity_date_start'];
            $validity_date_end = $row['validity_date_end'] ?? null;
            $position = $row['position'];

            // Determinar dependency_category y dependency_subcategory
            $dependency_category = '';
            $dependency_subcategory = null;

            if ($this->dependencyCategory == 'Fiscalización') {
                $dependency_category = 'Fiscalización';
                $dependency_subcategory = null;
            } elseif ($this->dependencyCategory == 'Peritos') {
                $dependency_category = 'Desarrollo Urbano';
                $dependency_subcategory = 'Perito';
            } elseif ($this->dependencyCategory == 'Inspectores') {
                $dependency_category = 'Desarrollo Urbano';
                $dependency_subcategory = 'Inspector';
            }

            // Verificar si el trabajador ya existe
            $worker = UrbanDevWorker::where('employee_number', $employee_number)->first();
            
            // Solo crear si no existe y los campos requeridos están presentes
            if (empty($worker) && $employee_number != NULL && $name != NULL && $last_name != NULL && $issue_date != NULL && $validity_date_start != NULL && $position != NULL) {
                
                // Convertir fechas de Excel a formato Carbon
                $issue_date = $this->transformDate($issue_date);
                $validity_date_start = $this->transformDate($validity_date_start);
                $validity_date_end = $validity_date_end ? $this->transformDate($validity_date_end) : null;

                $data = UrbanDevWorker::create([
                    'employee_number' => $employee_number,
                    'name' => $name,
                    'last_name' => $last_name,
                    'issue_date' => $issue_date,
                    'validity_date_start' => $validity_date_start,
                    'validity_date_end' => $validity_date_end,
                    'position' => $position,
                    'dependency_category' => $dependency_category,
                    'dependency_subcategory' => $dependency_subcategory,
                ]);
            }
        }
    }

    /**
     * Transforma la fecha de Excel a formato Carbon
     */
    private function transformDate($value)
    {
        if (is_numeric($value)) {
            // Excel almacena fechas como números seriales desde 1900-01-01
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        }
        
        // Si ya es una fecha en formato string, intentar parsearla
        return Carbon::parse($value);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
