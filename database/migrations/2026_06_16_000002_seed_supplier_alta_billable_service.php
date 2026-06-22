<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Servicio cobrable para el pago en línea de la Solicitud de Alta de Proveedor.
     * El nombre debe coincidir EXACTAMENTE con el que busca CartController::addSupplierAltaToCart().
     */
    public function up(): void
    {
        $exists = DB::table('billable_services')
            ->where('name', 'Solicitud Alta de Proveedor')
            ->exists();

        if (!$exists) {
            DB::table('billable_services')->insert([
                'name'        => 'Solicitud Alta de Proveedor',
                'description' => 'Pago de inscripción al Padrón de Proveedores del Municipio de Valle de Santiago, Gto.',
                'unit_price'  => 1000.00,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('billable_services')
            ->where('name', 'Solicitud Alta de Proveedor')
            ->delete();
    }
};
