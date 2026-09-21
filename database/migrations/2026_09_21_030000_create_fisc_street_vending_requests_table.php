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
        Schema::create('fisc_street_vending_requests', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->unsigned();
            $table->string('folio')->nullable();
            $table->string('status')->default('nueva_solicitud');

            // Datos del solicitante
            $table->string('full_name');
            $table->string('phone');
            $table->string('address');

            // Datos de la instalación a solicitud
            $table->string('business_type');
            $table->string('installation_type');

            // Dimensiones
            $table->string('front_meters')->nullable();
            $table->string('depth_meters')->nullable();

            // Mobiliario
            $table->integer('awning_qty')->nullable();
            $table->integer('cart_qty')->nullable();
            $table->integer('table_qty')->nullable();
            $table->integer('chairs_qty')->nullable();

            // Espacio principal (opción 1)
            $table->string('option1_street');
            $table->string('option1_between_streets')->nullable();
            $table->string('option1_photo_name')->nullable();
            $table->text('option1_photo_s3_url')->nullable();

            // Espacio alterno 2 (opción 2)
            $table->string('option2_street')->nullable();
            $table->string('option2_photo_name')->nullable();
            $table->text('option2_photo_s3_url')->nullable();

            // Espacio alterno 3 (opción 3)
            $table->string('option3_street')->nullable();
            $table->string('option3_photo_name')->nullable();
            $table->text('option3_photo_s3_url')->nullable();

            // Días y horario
            $table->string('work_days')->nullable();
            $table->string('schedule_from')->nullable();
            $table->string('schedule_to')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fisc_street_vending_requests');
    }
};
