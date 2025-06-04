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
        Schema::create('tsr_account_due_provisional_integers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('account_due_profile_id')->unsigned();

            $table->string('dependency_name')->nullable();
            $table->string('qty_text')->nullable();
            $table->string('qty_integer')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('basis')->nullable();
            $table->longText('concept')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('created_by')->nullable();
            $table->string('director')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_account_due_provisional_integers');
    }
};
