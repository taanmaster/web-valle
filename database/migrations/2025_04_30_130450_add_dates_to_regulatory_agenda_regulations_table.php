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
        Schema::table('regulatory_agenda_regulations', function (Blueprint $table) {
            $table->date('expeditions_date')->nullable(); // Cambia la columna a nullable
            $table->date('update_date')->nullable(); // Nueva columna publication_date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regulatory_agenda_regulations', function (Blueprint $table) {
            $table->dropColumn('expeditions_date'); // Elimina la columna expeditions_date
            $table->dropColumn('update_date'); // Elimina la columna publication_date
        });
    }
};
