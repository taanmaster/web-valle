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
        /* Este modulo funciona como un repositorio de archivos que se suben al sistema para generar una liga única y permantente que se pueda usar en el modulo de documentos */
        /* Estos archivos deben estar clasificados por dependencia para su posterior utilización en las obligaciones */
        Schema::create('transparency_files', function (Blueprint $table) {
            $table->id();

            $table->integer('dependency_id')->unsigned();

            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();

            $table->string('filename');
            $table->string('file_extension')->nullable();

            $table->string('permalink')->nullable();            

            $table->integer('uploaded_by')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparency_files');
    }
};
