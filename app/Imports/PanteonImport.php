<?php

namespace App\Imports;

use App\Models\Panteon;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PanteonImport implements ToCollection
{
    public int $created = 0;

    public int $skipped = 0;

    public array $rowErrors = [];

    public array $missingColumns = [];

    public function collection(Collection $rows): void
    {
        $header = $this->findHeader($rows);

        if ($header === null) {
            $this->missingColumns = $this->requiredColumnLabels();

            return;
        }

        $columnIndexes = $this->columnIndexes($header['row']->toArray());
        $this->missingColumns = $this->missingRequiredColumns($columnIndexes);

        if ($this->missingColumns !== []) {
            return;
        }

        foreach ($rows->slice($header['index'] + 1) as $index => $row) {
            $rowNumber = $index + 1;
            $values = $row->toArray();

            if ($this->isEmptyRow($values)) {
                continue;
            }

            $date = $this->parseDate($this->value($values, $columnIndexes['fecha']));
            if ($this->value($values, $columnIndexes['fecha']) !== '' && $date === null) {
                $this->rowErrors[$rowNumber][] = 'Fecha no válida; se guardó vacía.';
            }

            Panteon::create([
                'fecha'              => $date,
                'entero'             => $this->value($values, $columnIndexes['entero']),
                'folio'              => $this->value($values, $columnIndexes['folio']),
                'nombre_solicitante' => $this->value($values, $columnIndexes['nombre_solicitante']),
                'concepto'           => $this->value($values, $columnIndexes['concepto']),
                'nombre_finado'      => $this->value($values, $columnIndexes['nombre_finado']),
                'panteon'            => $this->value($values, $columnIndexes['panteon']),
                'seccion'            => $this->value($values, $columnIndexes['seccion']),
                'manzana'            => $this->value($values, $columnIndexes['manzana']),
                'terreno'            => $this->value($values, $columnIndexes['terreno']),
                'monto'              => $this->value($values, $columnIndexes['monto']),
                'observaciones'      => $this->observations($values, $columnIndexes),
            ]);

            $this->created++;
        }
    }

    private function findHeader(Collection $rows): ?array
    {
        foreach ($rows as $index => $row) {
            $columnIndexes = $this->columnIndexes($row->toArray());
            $matchedColumns = count(array_filter($columnIndexes, static fn ($value) => $value !== null));

            if ($matchedColumns >= 6
                && $columnIndexes['fecha'] !== null
                && $columnIndexes['nombre_solicitante'] !== null
                && $columnIndexes['concepto'] !== null) {
                return compact('index', 'row');
            }
        }

        return null;
    }

    private function columnIndexes(array $header): array
    {
        $columns = [];

        foreach ($header as $index => $value) {
            $normalized = $this->normalizeHeader((string) $value);

            if ($normalized !== '') {
                $columns[$normalized] = $index;
            }
        }

        return [
            'fecha'              => $this->findColumn($columns, ['fecha']),
            'entero'             => $this->findColumn($columns, ['entero']),
            'folio'              => $this->findColumn($columns, ['folio']),
            'nombre_solicitante' => $this->findColumn($columns, ['nombre', 'nombre solicitante', 'solicitante']),
            'concepto'           => $this->findColumn($columns, ['concepto']),
            'nombre_finado'      => $this->findColumn($columns, ['finado', 'nombre finado', 'difunto']),
            'panteon'            => $this->findColumn($columns, ['panteon']),
            'seccion'            => $this->findColumn($columns, ['seccion']),
            'manzana'            => $this->findColumn($columns, ['manzana o bloque', 'manzana bloque', 'manzana', 'bloque']),
            'terreno'            => $this->findColumn($columns, ['terreno', 'lote']),
            'monto'              => $this->findColumn($columns, ['cantidad', 'monto', 'importe']),
            'observaciones'      => $this->findColumn($columns, ['observaciones', 'observacion', 'obs', 'notas']),
            'estatus'            => $this->findColumn($columns, ['estatus', 'status']),
        ];
    }

    private function findColumn(array $columns, array $aliases): ?int
    {
        foreach ($aliases as $alias) {
            if (array_key_exists($alias, $columns)) {
                return $columns[$alias];
            }
        }

        return null;
    }

    private function missingRequiredColumns(array $columnIndexes): array
    {
        $missing = [];

        foreach ($this->requiredColumnLabels() as $field => $label) {
            if ($field === 'observaciones') {
                if ($columnIndexes['observaciones'] === null && $columnIndexes['estatus'] === null) {
                    $missing[] = $label;
                }

                continue;
            }

            if ($columnIndexes[$field] === null) {
                $missing[] = $label;
            }
        }

        return $missing;
    }

    private function requiredColumnLabels(): array
    {
        return [
            'fecha'              => 'Fecha',
            'entero'             => 'Entero',
            'folio'              => 'Folio',
            'nombre_solicitante' => 'Nombre',
            'concepto'           => 'Concepto',
            'nombre_finado'      => 'Finado',
            'panteon'            => 'Panteón',
            'seccion'            => 'Sección',
            'manzana'            => 'Manzana o bloque',
            'terreno'            => 'Terreno',
            'monto'              => 'Cantidad',
            'observaciones'      => 'Observaciones o estatus',
        ];
    }

    private function value(array $values, ?int $index): ?string
    {
        if ($index === null || !array_key_exists($index, $values)) {
            return null;
        }

        $value = trim((string) $values[$index]);

        return $value === '' ? null : $value;
    }

    private function observations(array $values, array $columnIndexes): ?string
    {
        $observations = $this->value($values, $columnIndexes['observaciones']);
        $status = $this->value($values, $columnIndexes['estatus']);

        if ($observations === null) {
            return $status;
        }

        if ($status === null || $status === $observations) {
            return $observations;
        }

        return "Observaciones: {$observations}\nEstatus: {$status}";
    }

    private function parseDate(mixed $value): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        if (is_numeric($value) && (float) $value > 10_000) {
            return Carbon::instance(Date::excelToDateTimeObject((float) $value))->toDateString();
        }

        $value = preg_replace('/\s+/', '', (string) $value);
        $value = preg_replace('#/+#', '/', $value);

        if (!preg_match('/^(\d{1,2})[\/-](\d{1,2})[\/-](\d{4})$/', $value, $matches)) {
            return null;
        }

        $first = (int) $matches[1];
        $second = (int) $matches[2];
        $year = (int) $matches[3];

        if ($first > 12) {
            [$day, $month] = [$first, $second];
        } else {
            [$month, $day] = [$first, $second];
        }

        if (!checkdate($month, $day, $year)) {
            return null;
        }

        return Carbon::create($year, $month, $day)->toDateString();
    }

    private function isEmptyRow(array $values): bool
    {
        foreach ($values as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    private function normalizeHeader(string $header): string
    {
        $header = mb_strtolower(trim($header));
        $header = strtr($header, [
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ü' => 'u',
            'ñ' => 'n',
        ]);

        return preg_replace('/\s+/', ' ', $header);
    }
}