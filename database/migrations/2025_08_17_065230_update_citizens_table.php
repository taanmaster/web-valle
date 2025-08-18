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
        Schema::table('citizens', function (Blueprint $table) {

            // agregar columnas nuevas
            $table->string('street')->nullable()->unique()->after('address');
            $table->string('colony')->nullable()->after('street');

            // agregar restricciones únicas
            $table->unique('curp');
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
