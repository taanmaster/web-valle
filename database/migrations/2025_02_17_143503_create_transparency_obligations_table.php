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
        /* Las obligaciones son las tareas que deben realizar las dependencias, aqui se suben los documentos que comprueban que se han cumplido */
        Schema::create('transparency_obligations', function (Blueprint $table) {
            $table->id();

            $table->integer('dependency_id')->unsigned();

            $table->string('name');
            $table->text('description')->nullable();

            $table->string('type');
            $table->string('update_period');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparency_obligations');
    }
};
