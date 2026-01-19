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
        Schema::dropIfExists('tsr_account_due_provisional_integer_folios');

        Schema::create('tsr_account_due_provisional_integer_folios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('provisional_integer_id');

            $table->foreign('provisional_integer_id', 'prov_int_folios_prov_int_id_fk')
                ->references('id')
                ->on('tsr_account_due_provisional_integers')
                ->onDelete('cascade');

            $table->string('folio');
            $table->decimal('quantity', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_account_due_provisional_integer_folios');
    }
};
