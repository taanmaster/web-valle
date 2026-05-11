<?php

namespace App\Imports;

use App\Models\Citizen;
use App\Models\FinancialSupport;
use App\Models\FinancialSupportType;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FinancialSupportImport implements ToCollection
{
    /** @var array<string> Columnas faltantes acumuladas */
    public array $missingColumns = [];

    /** @var array<int, array<string>> Errores por fila: [rowNum => [col1, col2, ...]] */
    public array $rowErrors = [];

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            return;
        }

        // --- Fila 1: leer encabezados y construir mapa normalizado ---
        $headerRow = $rows->first();
        $columnMap = []; // normalized_header => column_index

        foreach ($headerRow as $index => $header) {
            $normalized = $this->normalizeHeader((string) $header);
            if ($normalized !== '') {
                $columnMap[$normalized] = $index;
            }
        }

        // Alias aceptados por columna esperada
        $aliases = [
            'fecha'          => ['fecha'],
            'tipos_de_apoyo' => ['tipos de apoyo', 'tipo de apoyo', 'tipo apoyo', 'tipos apoyo'],
            'apellido_p'     => ['apellido p', 'apellido paterno', 'apellido p (apellido paterno)', 'apellido p(apellido paterno)', 'primer apellido'],
            'apellido_m'     => ['apellido m', 'apellido materno', 'apellido m (apellido materno)', 'apellido m(apellido materno)', 'segundo apellido'],
            'nombre'         => ['nombre', 'nombres'],
            'curp'           => ['curp'],
            'calle'          => ['calle'],
            'numero'         => ['numero', 'num', 'num.', 'no.', 'no'],
            'colonia'        => ['colonia', 'col', 'col.'],
            'seccional'      => ['seccional', 'seccion', 'seccion electoral', 'ine seccion', 'seccion ine'],
            'telefono'       => ['telefono', 'tel', 'tel.', 'celular'],
            'observaciones'  => ['observaciones', 'observacion', 'obs', 'notas'],
        ];

        // Resolver índice real para cada campo
        $colIndex = [];
        foreach ($aliases as $field => $possibleNames) {
            $colIndex[$field] = null;
            foreach ($possibleNames as $alias) {
                if (isset($columnMap[$alias])) {
                    $colIndex[$field] = $columnMap[$alias];
                    break;
                }
            }
        }

        // Campos requeridos para validación
        $requiredFields = [
            'fecha'          => 'Fecha',
            'tipos_de_apoyo' => 'Tipos de Apoyo',
            'nombre'         => 'Nombre',
            'curp'           => 'CURP',
            'apellido_p'     => 'Apellido P',
        ];

        // Obtener el último int_num para autoincrement
        $lastSupport = FinancialSupport::orderBy('int_num', 'desc')->first();
        $nextIntNum  = $lastSupport ? ((int) $lastSupport->int_num + 1) : 1;

        // --- Procesar desde fila 2 ---
        foreach ($rows->skip(1) as $rowOffset => $row) {
            $rowNum = $rowOffset + 2; // 1-based, +1 por header, +1 por base-0
            $rowArr = $row->toArray();

            // Extraer valores usando el mapa de índices
            $get = function (string $field) use ($colIndex, $rowArr): string {
                $idx = $colIndex[$field];
                return $idx !== null ? trim((string) ($rowArr[$idx] ?? '')) : '';
            };

            $fecha         = $colIndex['fecha'] !== null ? ($rowArr[$colIndex['fecha']] ?? null) : null;
            $tipoApoyo     = $get('tipos_de_apoyo');
            $apellidoP     = $get('apellido_p');
            $apellidoM     = $get('apellido_m');
            $nombre        = $get('nombre');
            $curp          = strtoupper($get('curp'));
            $calle         = $get('calle');
            $numero        = $get('numero');
            $colonia       = $get('colonia');
            $seccional     = $get('seccional');
            $telefono      = $get('telefono');
            $observaciones = $get('observaciones');

            // Saltar filas completamente vacías
            if (empty($fecha) && empty($curp) && empty($nombre)) {
                continue;
            }

            // Validar campos requeridos — reportar por fila
            $faltantes = [];
            foreach ($requiredFields as $field => $label) {
                $value = ($field === 'fecha') ? $fecha : $get($field);
                if (empty($value)) {
                    $faltantes[] = $label;
                    $this->missingColumns[] = $label;
                }
            }

            if (!empty($faltantes)) {
                $this->rowErrors[$rowNum] = $faltantes;
                continue;
            }

            // --- 1. Citizen: upsert por CURP ---
            $street  = trim($calle . ' ' . $numero);
            $citizen = Citizen::updateOrCreate(
                ['curp' => $curp],
                [
                    'name'        => $nombre,
                    'first_name'  => $apellidoP,
                    'last_name'   => $apellidoM,
                    'phone'       => $telefono ?: null,
                    'street'      => $street,
                    'colony'      => $colonia,
                    'ine_section' => $seccional,
                ]
            );

            // --- 2. FinancialSupportType: find-or-create por nombre ---
            $supportType = FinancialSupportType::firstOrCreate(
                ['name' => $tipoApoyo],
                ['monthly_cap' => 100]
            );

            // --- 3. Parsear fecha ---
            if (is_numeric($fecha)) {
                $utcDate     = Carbon::createFromTimestamp(($fecha - 25569) * 86400, 'UTC');
                $fechaCarbon = Carbon::create($utcDate->year, $utcDate->month, $utcDate->day, 12, 0, 0);
            } elseif (preg_match('/^\d{4}$/', trim((string) $fecha))) {
                $fechaCarbon = Carbon::createFromFormat('Y', trim((string) $fecha))->startOfYear()->setTime(12, 0, 0);
            } elseif (preg_match('/^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}$/', trim((string) $fecha))) {
                $normalized  = str_replace('-', '/', trim((string) $fecha));
                $fechaCarbon = Carbon::createFromFormat('d/m/Y', $normalized)->setTime(12, 0, 0);
            } else {
                $fechaCarbon = Carbon::parse($fecha)->setTime(12, 0, 0);
            }

            // --- 4. Validar duplicado (mismo ciudadano, mismo día) ---
            $existeApoyo = FinancialSupport::where('citizen_id', $citizen->id)
                ->whereBetween('created_at', [
                    $fechaCarbon->copy()->startOfDay(),
                    $fechaCarbon->copy()->endOfDay(),
                ])
                ->exists();

            if ($existeApoyo) {
                continue;
            }

            // --- 5. Crear FinancialSupport ---
            $support              = new FinancialSupport();
            $support->citizen_id  = $citizen->id;
            $support->int_num     = $nextIntNum++;
            $support->name        = $nombre;
            $support->first_name  = $apellidoP;
            $support->last_name   = $apellidoM;
            $support->qty         = $supportType->monthly_cap ?? 100;
            $support->type_id     = $supportType->id;
            $support->phone       = $telefono ?: null;
            $support->observaciones = $observaciones ?: null;
            $support->timestamps  = false;
            $support->created_at  = $fechaCarbon;
            $support->updated_at  = $fechaCarbon;
            $support->save();
        }
    }

    /**
     * Normaliza un encabezado: minúsculas, sin acentos, espacios simples.
     */
    private function normalizeHeader(string $header): string
    {
        $header = mb_strtolower(trim($header));
        $from   = ['á','é','í','ó','ú','ü','ñ'];
        $to     = ['a','e','i','o','u','u','n'];
        $header = str_replace($from, $to, $header);
        return preg_replace('/\s+/', ' ', $header);
    }
}