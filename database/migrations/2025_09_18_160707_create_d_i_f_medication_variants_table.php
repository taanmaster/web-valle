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
        Schema::create('d_i_f_medication_variants', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('medication_id');
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('price')->nullable();

            $table->string('type')->nullable(); // Presentación : Tableta, Cápsula, Píldora, Supositorio, Jarabe, Gotas
            $table->string('type_num')->nullable(); // Cantidad (ej. 30, 500)
            $table->string('type_dosage')->nullable(); // Unidad de medida (ej. mg, gr, ml)

            $table->string('use_type')->nullable(); // Via de Administración: Oral, Tópica, Oftálmica, Ótica, Inyectable

            $table->json('attributes_json')->nullable();

            $table->timestamps();
        });

        Schema::table('d_i_f_medications', function (Blueprint $table) {
            $table->dropColumn('expiration_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('d_i_f_medications', function (Blueprint $table) {
            $table->date('expiration_date')->default(now());
        });

        Schema::dropIfExists('d_i_f_medication_variants');
    }
};
