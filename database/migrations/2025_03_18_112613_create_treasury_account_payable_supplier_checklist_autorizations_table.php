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
        Schema::create('treasury_account_payable_supplier_checklist_autorizations', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('supplier_checklist_id')->unsigned();

            $table->string('folio')->nullable();

            $table->string('title');
            $table->string('type');

            // Banco Emisor
            $table->string('sender_bank_name')->nullable();
            $table->string('sender_account_number')->nullable();

            $table->string('financing_fund')->nullable();

            // Banco Receptor
            $table->string('receiver_bank_name')->nullable(); 
            $table->string('receiver_account_number')->nullable();  

            // Beneficiario
            $table->string('recipient_name')->nullable();

            // Usuarios Involucrados
            $table->string('transaction_by')->nullable();
            $table->string('authorized_by')->nullable();
            $table->string('reviewed_by')->nullable();
            $table->string('redacted_by')->nullable();

            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury_account_payable_supplier_checklist_autorizations');
    }
};
