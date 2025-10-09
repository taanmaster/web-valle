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
        Schema::create('urban_dev_workers', function (Blueprint $table) {
            $table->id();

            // Imagen de Perfil
            $table->string('s3_asset_url')->nullable();
            $table->string('filesize')->nullable();

            $table->string('employee_number')->unique();
            $table->string('name'); //Nombre(s)
            $table->string('last_name'); //Apellido(s)
            $table->date('issue_date'); // Fecha de expedición de la credencial
            $table->date('validity_date_start'); // Fecha de inicio de vigencia
            $table->date('validity_date_end')->nullable(); // Fecha de fin de vigencia
            $table->string('position'); // Puesto, Cargo

            $table->string('dependency_category'); // Desarrollo Urbano, Fiscalización. (Fiscalización = auditors)
            $table->string('dependency_subcategory')->nullable(); // Se pertenece a Desarrollo Urbano puede ser Inspector o Perito (inspectors, experts)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urban_dev_workers');
    }
};
