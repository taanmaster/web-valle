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
        Schema::table('urban_dev_formats', function (Blueprint $table) {
            // Documentación exigida cuando el solicitante es Persona Moral
            $table->string('documento_personalidad_path')->nullable()->after('croquis_path');
            $table->string('ine_representante_path')->nullable()->after('documento_personalidad_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('urban_dev_formats', function (Blueprint $table) {
            $table->dropColumn(['documento_personalidad_path', 'ine_representante_path']);
        });
    }
};
