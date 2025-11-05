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
        Schema::create('supplier_files', function (Blueprint $table) {
            $table->id();

            // Relación con el proveedor
            $table->unsignedBigInteger('supplier_id');
            $table->string('filename')->nullable(); // Nombre del archivo
            $table->string('filepath')->nullable(); // Ruta del archivo (Amazon Bucket S3)
            $table->string('file_type')->nullable(); // Tipo de archivo (ej. RFC, Comprobante Domicilio, etc.)
           
            $table->string('status')->default('pendiente'); // Estado del archivo (pendiente, aprobado, rechazado)
            $table->text('comments')->nullable(); // Comentarios adicionales

            // Aprobaciones
            $table->integer('approved_by')->nullable(); // ID del usuario que aprobó/rechazó
            $table->timestamp('approved_at')->nullable(); // Fecha y hora de aprobación/rechazo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_files');
    }
};
