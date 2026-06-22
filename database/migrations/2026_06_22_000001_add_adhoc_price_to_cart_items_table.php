<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Permite ítems de carrito con monto ad-hoc (sin BillableService del catálogo).
     * Necesario para trámites cuyo costo vive fuera de billable_services
     * (ej. Desarrollo Urbano, cuyos montos están en urban_dev_costs).
     * order_items ya soporta este snapshot; aquí lo replicamos en cart_items.
     */
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->string('service_name')->nullable()->after('billable_service_id');
            $table->decimal('unit_price', 10, 2)->nullable()->after('service_name');
        });

        // billable_service_id pasa a nullable (los ítems ad-hoc no referencian catálogo)
        DB::statement('ALTER TABLE cart_items MODIFY billable_service_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        // Restaurar NOT NULL solo si no hay ítems ad-hoc que lo violen
        DB::statement('DELETE FROM cart_items WHERE billable_service_id IS NULL');
        DB::statement('ALTER TABLE cart_items MODIFY billable_service_id BIGINT UNSIGNED NOT NULL');

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn(['service_name', 'unit_price']);
        });
    }
};
