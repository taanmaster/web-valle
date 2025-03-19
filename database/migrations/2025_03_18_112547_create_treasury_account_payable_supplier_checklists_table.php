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
        Schema::create('treasury_account_payable_supplier_checklists', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('checklist_id')->unsigned();

            $table->string('folio')->nullable();
            $table->date('received_at')->nullable();
            $table->date('return_date')->nullable();

            $table->bigInteger('dependency_id')->unsigned()->nullable();
            $table->string('dependency_name')->nullable();

            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->decimal('invoice_amount', 10, 2)->nullable();

            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury_account_payable_supplier_checklists');
    }
};
