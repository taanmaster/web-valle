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
        // Esta es la tabla de refrendos de proveedores
        // Un proveedor puede tener un refrendo por año en curso
        // Tiene una vigencia de un año, después de lo cual debe renovarse
        // Al pagar su refrendo y que sea aprobado, el estatus de proveedor pasa a Activo
        Schema::create('supplier_endorsements', function (Blueprint $table) {
            $table->id();

            // Relación con el proveedor y el usuario que crea el refrendo
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('supplier_id')->nullable();

            $table->string('endorsement_type')->default('anual'); // Tipo de refrendo
            $table->date('endorsement_date')->nullable(); // Fecha del refrendo (Se debe renovar anualmente)
            $table->string('filename')->nullable(); // Nombre del archivo de refrendo
            $table->string('filepath')->nullable(); // Ruta del archivo de refrendo (Amazon S3)
            
            $table->text('comments')->nullable(); // Comentarios adicionales

            $table->boolean('is_approved')->default(false); // Indica si el refrendo fue aprobado
            $table->timestamp('approved_at')->nullable(); // Fecha y hora de aprobación/rechazo
            $table->integer('approved_by')->nullable(); // ID del usuario que aprobó/rechazó

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_endorsements');
    }
};
