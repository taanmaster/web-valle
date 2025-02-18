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
        /* Con esta tabla se asocia un usuario a una dependencia */
        /* Una dependencia puede tener múltiples usuarios */
        /* Los roles generales aplicarán para todos los usuarios pero solo actuarán sobre la dependencia asignada */
        Schema::create('transparency_dependency_users', function (Blueprint $table) {
            $table->id();

            $table->integer('dependency_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparency_dependency_users');
    }
};
