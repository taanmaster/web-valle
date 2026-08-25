<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banbajio_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete()->index();
            $table->string('cl_folio')->nullable();
            $table->string('cl_referencia')->nullable();
            $table->string('cl_servicio')->nullable();
            $table->string('t_concepto')->nullable();
            $table->decimal('dl_monto', 10, 2)->nullable();
            $table->string('dt_fecha_pago')->nullable();
            $table->string('nl_tipo_pago', 2)->nullable();
            $table->string('nl_status', 2)->nullable();
            $table->text('hash');
            $table->boolean('hash_valid');
            $table->string('hash_variant')->nullable();
            $table->json('raw_payload');
            $table->string('response_sent');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banbajio_notifications');
    }
};