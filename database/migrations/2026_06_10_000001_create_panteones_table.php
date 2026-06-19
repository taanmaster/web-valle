<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panteones', function (Blueprint $table) {
            $table->id();
            $table->string('entero')->nullable();
            $table->string('folio')->nullable();
            $table->date('fecha')->nullable();
            $table->string('comprobante_pdf')->nullable();
            $table->string('nombre_solicitante')->nullable();
            $table->string('nombre_finado')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('localidad')->nullable();
            $table->string('fundamento_legal')->nullable();
            $table->string('concepto')->nullable();
            $table->string('tipo')->nullable();
            $table->string('zona')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('panteon')->nullable();
            $table->string('seccion')->nullable();
            $table->string('bloque')->nullable();
            $table->string('manzana')->nullable();
            $table->string('terreno')->nullable();
            $table->string('ref_art')->nullable();
            $table->string('ref_frac')->nullable();
            $table->string('ref_inc')->nullable();
            $table->string('ref_num')->nullable();
            $table->string('monto')->nullable();
            $table->string('cantidad_letra')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panteones');
    }
};
