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
        Schema::create('backoffice_dependencies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->comment('Código único de la dependencia (ej: TS, DIF, etc.)');
            $table->string('name')->comment('Nombre de la dependencia');
            $table->string('responsible_name')->comment('Director/Responsable de la dependencia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backoffice_dependencies');
    }
};
