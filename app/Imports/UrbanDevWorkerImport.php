<?php

namespace App\Imports;

use App\Models\UrbanDevWorker;
use Carbon\Carbon;

// Importación por medio de Colección
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Clase para importar trabajadores de Desarrollo Urbano desde archivos Excel
 * 
 * Esta clase procesa archivos Excel y crea registros de trabajadores en la base de datos,
 * asignando automáticamente las categorías y subcategorías de dependencia según el tipo seleccionado.
 * 
 * FORMATO DEL ARCHIVO EXCEL:
 * El archivo debe contener las siguientes columnas en la primera fila (encabezados):
 * - employee_number: Número de empleado (requerido, único)
 * - name: Nombre(s) del trabajador (requerido)
 * - last_name: Apellido(s) del trabajador (requerido)
 * - issue_date: Fecha de emisión de la credencial (requerido, formato fecha Excel)
 * - validity_date_start: Fecha de inicio de vigencia (requerido, formato fecha Excel)
 * - validity_date_end: Fecha de fin de vigencia (opcional, formato fecha Excel)
 * - position: Puesto/Cargo del trabajador (requerido)
 * - email: Correo electrónico (opcional)
 * - phone: Teléfono (opcional)
 * - extension: Extensión telefónica (opcional)
 * 
 * CATEGORÍAS SOPORTADAS:
 * Al importar, se debe seleccionar una de las siguientes categorías:
 * 
 * 1. "Fiscalización"
 *    - dependency_category: Fiscalización
 *    - dependency_subcategory: null
 * 
 * 2. "Peritos"
 *    - dependency_category: Desarrollo Urbano
 *    - dependency_subcategory: Perito
 * 
 * 3. "Inspectores"
 *    - dependency_category: Desarrollo Urbano
 *    - dependency_subcategory: Inspector
 * 
 * 4. "Protección Civil"
 *    - dependency_category: Protección Civil
 *    - dependency_subcategory: null
 * 
 * VALIDACIÓN DEL FORMULARIO:
 * El controlador valida que dependency_category sea uno de los siguientes valores exactos:
 * 'Peritos', 'Inspectores', 'Fiscalización', 'Protección Civil'
 * 
 * NOTA: Los valores deben coincidir exactamente con las tildes y mayúsculas.
 * 
 * COMPORTAMIENTO:
 * - Los registros duplicados (por employee_number) son ignorados automáticamente
 * - Las fechas en formato numérico de Excel se convierten automáticamente a Carbon
 * - Los campos opcionales pueden dejarse vacíos en el Excel
 * - Solo se crean registros si todos los campos requeridos tienen valores válidos
 * 
 * @package App\Imports
 */
class UrbanDevWorkerImport implements ToCollection, WithHeadingRow
{
    /**
     * Categoría de dependencia seleccionada en el formulario de importación
     * Valores posibles: 'Fiscalización', 'Peritos', 'Inspectores', 'Protección Civil'
     * 
     * @var string
     */
    protected $dependencyCategory;

    /**
     * Constructor de la clase
     * 
     * @param string $dependencyCategory Categoría seleccionada en el formulario
     */
    public function __construct($dependencyCategory)
    {
        $this->dependencyCategory = $dependencyCategory;
    }

    /**
     * Procesa las filas del archivo Excel
     * 
     * @param Collection $rows Colección de filas del archivo Excel
     * @return void
     */
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
            $email = $row['email'] ?? null;
            $phone = $row['phone'] ?? null;
            $extension = $row['extension'] ?? null;

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
            } elseif ($this->dependencyCategory == 'Protección Civil') {
                $dependency_category = 'Protección Civil';
                $dependency_subcategory = null;
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
                    'email' => $email,
                    'phone' => $phone,
                    'extension' => $extension,
                    'dependency_category' => $dependency_category,
                    'dependency_subcategory' => $dependency_subcategory,
                ]);
            }
        }
    }

    /**
     * Transforma la fecha de Excel a formato Carbon
     * 
     * @param mixed $value Valor de fecha (puede ser numérico de Excel o string)
     * @return Carbon Fecha convertida a Carbon
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

    /**
     * Define la fila donde están los encabezados del Excel
     * 
     * @return int Número de fila (1 = primera fila)
     */
    public function headingRow(): int
    {
        return 1;
    }
}
