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
        Schema::create('urban_dev_requests', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->unsigned();
            $table->string('status')->default('new'); // Options: new, in_progress, cancelled, payment_pending, authorized, rejected, validation
            $table->string('request_type')->default('general'); // Options: uso de suelo; constancia de factibilidad, permiso de anuncios, certificación de número oficial, permiso de división, uso de vía pública, licencia de construcción, permiso de construcción en panteones.
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urban_dev_requests');
    }
};
