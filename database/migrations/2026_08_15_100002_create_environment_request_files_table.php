<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Archivos de una solicitud de Medio Ambiente, almacenados en S3.
     * document_type distingue los tres adjuntos de Donación
     * (ine | carta_compromiso | solicitud_donacion) de la evidencia
     * fotográfica que sube la Dirección (evidencia).
     */
    public function up(): void
    {
        Schema::create('environment_request_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('environment_request_id');
            $table->string('document_type');

            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('filename');
            $table->string('file_extension')->nullable();
            $table->unsignedBigInteger('filesize')->nullable();
            $table->text('s3_asset_url')->nullable();

            $table->timestamps();

            $table->index(['environment_request_id', 'document_type'], 'env_req_files_request_doc_type_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('environment_request_files');
    }
};
