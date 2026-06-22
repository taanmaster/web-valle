<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Las constancias de identificación solo se pagan desde su trámite
     * (vista de constancias del ciudadano), no como compra genérica del
     * catálogo. Se marcan requires_procedure=true para sacarlas del catálogo
     * y bloquear el agregado genérico al carrito.
     */
    public function up(): void
    {
        DB::table('billable_services')
            ->whereIn('name', ['Constancia de Residencia', 'Constancia de Origen e Identidad'])
            ->update(['requires_procedure' => true]);
    }

    public function down(): void
    {
        DB::table('billable_services')
            ->whereIn('name', ['Constancia de Residencia', 'Constancia de Origen e Identidad'])
            ->update(['requires_procedure' => false]);
    }
};
