<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Servicios "solo por trámite": no aparecen en el catálogo público ni se
     * pueden agregar genéricamente al carrito. Solo se vinculan vía el flujo
     * de su trámite (ej. la Solicitud de Alta de Proveedor), que fija el
     * related_model y respeta la regla 1 servicio = 1 orden = 1 trámite.
     */
    public function up(): void
    {
        Schema::table('billable_services', function (Blueprint $table) {
            $table->boolean('requires_procedure')->default(false)->after('is_active');
        });

        DB::table('billable_services')
            ->where('name', 'Solicitud Alta de Proveedor')
            ->update(['requires_procedure' => true]);
    }

    public function down(): void
    {
        Schema::table('billable_services', function (Blueprint $table) {
            $table->dropColumn('requires_procedure');
        });
    }
};
