<?php

namespace Tests\Unit\Imports;

use App\Imports\PanteonImport;
use App\Models\Panteon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PanteonImportTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('panteones');

        Schema::create('panteones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->string('entero')->nullable();
            $table->string('folio')->nullable();
            $table->string('nombre_solicitante')->nullable();
            $table->string('concepto')->nullable();
            $table->string('nombre_finado')->nullable();
            $table->string('panteon')->nullable();
            $table->string('seccion')->nullable();
            $table->string('manzana')->nullable();
            $table->string('terreno')->nullable();
            $table->string('monto')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function test_imports_historical_rows_with_shifted_headers_and_preserves_duplicates(): void
    {
        $import = new PanteonImport();

        $import->collection(collect([
            collect(['INGRESO DE PANTEONES 2004']),
            collect(['FECHA', 'ENTERO', 'FOLIO', 'NOMBRE', 'CONCEPTO', 'FINADO', 'PANTEON', 'SECCION', 'MANZANA O BLOQUE', 'TERRENO', 'CANTIDAD', 'ESTATUS']),
            collect(['1/4/1982', '1', '4', 'CONCEPCION PAREDES', 'INHUMACION', 'CONCEPCION PAREDES', 'CAMPO FLORIDO', 'A', 'BLOQUE 3', '12', '$250.00', 'PAGADO']),
            collect(['16/02//1982', '2', '5', 'JUAN PEREZ', 'REFRENDO', 'JUAN PEREZ', 'SEÑOR SANTIAGO', 'B', 'MANZANA 5', '9', 'CONDONADO', 'SIN RECIBO']),
            collect(['1/4/1982', '1', '4', 'CONCEPCION PAREDES', 'INHUMACION', 'CONCEPCION PAREDES', 'CAMPO FLORIDO', 'A', 'BLOQUE 3', '12', '$250.00', 'PAGADO']),
        ]));

        $this->assertSame(3, $import->created);
        $this->assertSame(3, Panteon::count());

        $first = Panteon::orderBy('id')->firstOrFail();
        $second = Panteon::orderBy('id')->skip(1)->firstOrFail();

        $this->assertSame('1982-01-04', $first->fecha->toDateString());
        $this->assertSame('BLOQUE 3', $first->manzana);
        $this->assertSame('$250.00', $first->monto);
        $this->assertSame('PAGADO', $first->observaciones);
        $this->assertSame('1982-02-16', $second->fecha->toDateString());
        $this->assertSame('CONDONADO', $second->monto);
    }

    public function test_reports_missing_columns_without_creating_records(): void
    {
        $import = new PanteonImport();

        $import->collection(collect([
            collect(['FECHA', 'NOMBRE', 'CONCEPTO']),
            collect(['1/4/1982', 'CONCEPCION PAREDES', 'INHUMACION']),
        ]));

        $this->assertSame(0, $import->created);
        $this->assertSame(0, Panteon::count());
        $this->assertContains('Entero', $import->missingColumns);
        $this->assertContains('Observaciones o estatus', $import->missingColumns);
    }
}