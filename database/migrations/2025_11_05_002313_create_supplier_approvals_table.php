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
        Schema::create('supplier_approvals', function (Blueprint $table) {
            $table->id();

            // Relación con el proveedor
            $table->unsignedBigInteger('supplier_id');
            $table->integer('approved_by')->nullable(); // ID del usuario que aprobó/rechazó
            $table->string('filename')->nullable(); // Nombre del archivo de aprobación
            $table->string('filepath')->nullable(); // Ruta del archivo de aprobación (Amazon Bucket S3)
            $table->text('comments')->nullable(); // Comentarios adicionales

            // Autorizaciones
            $table->boolean('link_approval')->default(false); // Autorización por Enlace
            $table->text('link_approval_signature')->nullable(); // Firma de Autorización por Enlace
            $table->boolean('director_approval')->default(false); // Autorización por Director
            $table->text('director_approval_signature')->nullable(); // Firma de Autorización por Director
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_approvals');
    }
};
