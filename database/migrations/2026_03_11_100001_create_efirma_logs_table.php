<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('efirma_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')
                ->constrained('backoffice_documents')
                ->cascadeOnDelete();
            $table->string('event');
            $table->longText('payload')->nullable();
            $table->longText('response')->nullable();
            $table->integer('http_status')->nullable();
            $table->boolean('success')->default(false);
            $table->timestamps();

            $table->index(['document_id', 'event']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('efirma_logs');
    }
};
