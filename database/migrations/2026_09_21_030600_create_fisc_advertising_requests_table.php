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
        Schema::create('fisc_advertising_requests', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->unsigned();
            $table->string('folio')->nullable();
            $table->string('status')->default('nueva_solicitud');

            // Datos de la publicidad (captura exclusiva de Fiscalización)
            $table->string('advertising_type');
            $table->string('authorized_pieces')->nullable();
            $table->string('authorized_locations')->nullable();
            $table->string('authorized_period')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fisc_advertising_requests');
    }
};
