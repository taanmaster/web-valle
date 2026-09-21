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
        Schema::create('sare_request_reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sare_request_id');
            $table->foreign('sare_request_id')->references('id')->on('sare_requests')->onDelete('cascade');

            // Dependencia que atiende el dictamen. Hoy solo existe 'urban_dev', pero se deja
            // como columna para que otra dependencia pueda reutilizar la tabla sin nueva migración.
            $table->string('dependency')->default('urban_dev');

            // nuevo | en_proceso | completado — se recalcula automáticamente al guardar.
            $table->string('status')->default('nuevo');

            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('sent_by')->nullable();
            $table->foreign('sent_by')->references('id')->on('users')->onDelete('set null');

            // Inspección
            $table->unsignedBigInteger('inspector_id')->nullable();
            $table->foreign('inspector_id')->references('id')->on('urban_dev_workers')->onDelete('set null');
            $table->timestamp('inspection_date')->nullable();
            $table->string('measured_area')->nullable();
            $table->text('observations')->nullable();

            // Emisión del permiso
            $table->string('permit_document_name')->nullable();
            $table->text('permit_document_s3_url')->nullable();
            $table->unsignedBigInteger('permit_document_size')->nullable();

            // Entero de pago
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('payment_document_name')->nullable();
            $table->text('payment_document_s3_url')->nullable();
            $table->unsignedBigInteger('payment_document_size')->nullable();

            $table->timestamps();

            $table->unique(['sare_request_id', 'dependency']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sare_request_reviews');
    }
};
