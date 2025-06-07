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
        Schema::create('tsr_account_due_incomes', function (Blueprint $table) {
            $table->id();

            $table->string('department')->nullable();
            $table->string('concept')->nullable();

            $table->string('folio');
            $table->bigInteger('provisional_integer_id')->unsigned();

            // DATA BASED ON THE GIVEN FOLIO (PROVISIONAL INTEGER)
            $table->string('qty_text')->nullable();
            $table->string('qty_integer')->nullable();
            $table->string('name')->nullable();
            $table->string('type_of_person'); // Persona física o moral
            $table->string('rfc_curp')->nullable();
            $table->string('address')->nullable();
            $table->string('zipcode')->nullable();

            $table->string('code')->unique();

            $table->longText('observations')->nullable();
            $table->string('work')->nullable();
            $table->string('locality')->nullable();

            $table->string('basis')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_account_due_incomes');
    }
};
