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
        /* Este módulo funciona como un listado de documentos que se muestran en el portal de transparencia */
        /* Estos documentos pertenecen a las obligaciones dentro de cada dependencia */
        Schema::create('transparency_documents', function (Blueprint $table) {
            $table->id();

            $table->integer('obligation_id')->unsigned();

            $table->string('name');
            $table->text('description')->nullable();

            $table->string('period');
            $table->string('year');

            $table->string('filename');
            $table->string('file_extension')->nullable();

            $table->integer('uploaded_by')->unsigned();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparency_documents');
    }
};
