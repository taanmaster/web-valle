<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trn_proposals', function (Blueprint $table) {
            $table->id();

            $table->string('title'); // Name
            $table->text('description');
            $table->string('filename')->nullable(); // Nombre del archivo
            $table->string('filepath')->nullable(); // Ruta del archivo (Amazon Bucket S3)
            $table->string('file_type')->nullable(); // Tipo de archivo (ej. RFC, Comprobante Domicilio, etc.)
            $table->bigInteger('filesize'); // Tamaño del archivo en bytes
            $table->boolean('in_index')->default(true); // ¿Aparece en la pantalla front publica?

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_proposals');
    }
};
