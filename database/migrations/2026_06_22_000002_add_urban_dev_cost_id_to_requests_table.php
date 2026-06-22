<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Concepto de costo asignado por el admin al resolver el expediente.
     * Apunta a la línea de urban_dev_costs que determina el monto a pagar.
     */
    public function up(): void
    {
        Schema::table('urban_dev_requests', function (Blueprint $table) {
            $table->foreignId('urban_dev_cost_id')
                ->nullable()
                ->after('payment_amount')
                ->constrained('urban_dev_costs')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('urban_dev_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('urban_dev_cost_id');
        });
    }
};
