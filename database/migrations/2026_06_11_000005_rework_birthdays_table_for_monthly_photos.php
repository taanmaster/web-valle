<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Rediseño del módulo de cumpleaños: pasa de un registro por
     * cumpleañero a un registro por mes (1-12) con una foto.
     * Los datos por persona se descartan intencionalmente.
     */
    public function up(): void
    {
        Schema::dropIfExists('birthdays');

        Schema::create('birthdays', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('month')->unique();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('birthdays');

        Schema::create('birthdays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('area');
            $table->date('birthday_date');
            $table->timestamps();
        });
    }
};
