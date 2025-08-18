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
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->unsigned();

            $table->string('model_type')->nullable();
            $table->integer('model_id')->nullable()->unsigned();
            
            // Índices
            $table->index(['model_type', 'model_id']);
            $table->unique('user_id'); // Un usuario solo puede tener un perfil info

            $table->boolean('mail_notifications')->default(true);
            $table->boolean('sms_notifications')->default(true);
            $table->boolean('push_notifications')->default(true);

            // Metadatos adicionales si necesitas
            $table->json('additional_data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
