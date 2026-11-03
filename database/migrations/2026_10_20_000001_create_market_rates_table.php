<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tarifas del Mercado Municipal por ejercicio fiscal y tipo de espacio
        Schema::create('market_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('fiscal_year');
            // local · lugar · plancha
            $table->string('space_type');
            $table->string('article', 10);
            $table->string('subsection', 10);
            $table->string('fraction', 10);
            $table->string('description');
            $table->decimal('monthly_amount', 10, 2);
            $table->date('effective_from');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_rates');
    }
};
