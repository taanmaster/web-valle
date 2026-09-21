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
        Schema::create('fisc_workers', function (Blueprint $table) {
            $table->id();

            // Imagen de Perfil
            $table->text('s3_asset_url')->nullable();
            $table->string('filesize')->nullable();

            $table->string('employee_number')->nullable();
            $table->string('name'); // Nombre(s)
            $table->string('last_name'); // Apellido(s)
            $table->string('position'); // Puesto, Cargo
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('extension')->nullable();

            $table->date('issue_date')->nullable(); // Fecha de expedición de la credencial
            $table->date('validity_date_start')->nullable(); // Fecha de inicio de vigencia
            $table->date('validity_date_end')->nullable(); // Fecha de fin de vigencia

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fisc_workers');
    }
};
