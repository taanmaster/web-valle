<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('citizens', function (Blueprint $table) {

            // agregar columnas nuevas
            if (!Schema::hasColumn('citizens', 'street')) {
                $table->string('street')->nullable()->after('address');
            }
            if (!Schema::hasColumn('citizens', 'colony')) {
                $table->string('colony')->nullable()->after('street');
            }


            // agregar restricciones únicas solo si no existe previamente
            if (empty(DB::select('SELECT 1 FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name = ?', [DB::getDatabaseName(), 'citizens', 'citizens_curp_unique']))) {
                $table->unique('curp', 'citizens_curp_unique');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizens', function (Blueprint $table) {
            $table->dropColumn('colony');
            $table->dropColumn('street');
            $table->dropUnique('citizens_curp_unique');
        });
    }
};
