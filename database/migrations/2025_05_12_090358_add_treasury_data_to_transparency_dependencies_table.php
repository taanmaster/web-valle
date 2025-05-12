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
        Schema::table('transparency_dependencies', function (Blueprint $table) {
            // Este se usará más adelante para vincular la dependencia a multiples fuentes de datos
            $table->integer('belongs_to')->nullable()->after('id');

            // Este se usará para vincular la dependencia a la tesorería
            // Se usará para mostrar la dependencia en el listado de dependencias de la tesorería
            $table->boolean('belongs_to_treasury')->default(false)->after('image_cover');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transparency_dependencies', function (Blueprint $table) {
            $table->dropColumn('belongs_to');
            $table->dropColumn('belongs_to_treasury');
        });
    }
};
