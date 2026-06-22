<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Costos editables de los trámites de Desarrollo Urbano.
     * Cada renglón es una línea de costo de un trámite. El contenido
     * (descripción, unidad, pasos) es fijo; solo el monto se actualiza
     * desde el CRUD admin y se refleja en el front.
     */
    public function up(): void
    {
        Schema::create('urban_dev_costs', function (Blueprint $table) {
            $table->id();
            $table->string('tramite_slug');   // ej. 'uso-de-suelo'
            $table->string('tramite_title');  // ej. 'Licencia de Uso de Suelo'
            $table->string('description');     // ej. 'Uso habitacional, por vivienda'
            $table->decimal('amount', 10, 2); // monto editable
            $table->string('unit')->nullable(); // sufijo del precio, ej. 'x m2'
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();

            $table->index('tramite_slug');
        });

        // Seed con los montos actuales del front (resources/views/front/urban_dev/show.blade.php)
        $now  = now();
        $rows = [];
        $seed = [
            'uso-de-suelo' => ['Licencia de Uso de Suelo', [
                ['Uso habitacional, por vivienda', 771.84, null],
                ['Uso comercial, por local comercial', 984.24, null],
                ['Uso industrial, por predio', 2111.57, null],
            ]],
            'constancia-de-factibilidad' => ['Constancia de Factibilidad', [
                ['a) Constancias expedidas por la dependencia', 87.05, null],
            ]],
            'permiso-de-anuncios' => ['Permiso de Anuncios y Toldos', [
                ['Adosado', 692.31, 'x m2'],
                ['Autosoportado', 100.00, 'x m2'],
                ['Pinta de barda', 92.31, 'x m2'],
                ['Toldos y carpas', 978.81, null],
            ]],
            'certificacion-numero-oficial' => ['Certificación de Número Oficial', [
                ['Certificación de número oficial', 130.58, null],
                ['Constancia de Alineamiento', 41.07, 'x m2'],
            ]],
            'permiso-de-division' => ['Permiso de División', [
                ['Costo', 387.87, null],
            ]],
            'uso-de-via-publica' => ['Uso de Vía Pública', [
                ['Costo', 4.69, null],
            ]],
            'licencia-de-construccion' => ['Licencia de Construcción', [
                ['Hasta 40m2', 378.86, null],
                ['Por metro cuadrado excedente a 40m2', 8.36, null],
                ['Residencial y departamentos por m2', 14.61, null],
            ]],
            'permiso-construccion-panteones' => ['Permiso de Construcción en Panteones', [
                ['Construcción de gaveta', 250.00, null],
                ['Remodelación de gaveta', 289.00, null],
                ['Instalación de barandal metálico', 188.00, null],
                ['Instalación de techo metálico', 188.00, null],
                ['Recubrimiento de gaveta con aplanado, azulejo ó mármol', 63.00, null],
            ]],
        ];

        foreach ($seed as $slug => [$title, $costs]) {
            foreach ($costs as $i => [$description, $amount, $unit]) {
                $rows[] = [
                    'tramite_slug'  => $slug,
                    'tramite_title' => $title,
                    'description'   => $description,
                    'amount'        => $amount,
                    'unit'          => $unit,
                    'position'      => $i,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];
            }
        }

        DB::table('urban_dev_costs')->insert($rows);
    }

    public function down(): void
    {
        Schema::dropIfExists('urban_dev_costs');
    }
};
