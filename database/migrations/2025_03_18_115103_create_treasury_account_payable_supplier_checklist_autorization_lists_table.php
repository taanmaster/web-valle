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
        Schema::create('treasury_account_payable_supplier_checklist_autorization_lists', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('supplier_autorization_id')->unsigned();

            // Tipo puede ser 'autorizacion' o 'extra'
            // 'autorizacion' es para los documentos que se requieren para la autorizacion de pagos
            // 'extra' es para otros conceptos que no clasifican dentro de los documentos de autorizacion
            $table->string('type');

            // La columna name es para el nombre del Concepto 
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('subtotal')->nullable();

            // La columna total se usa tambien en extra para el campo de "Costo"
            $table->string('total')->nullable();

            $table->bigInteger('dependency_id')->unsigned()->nullable();
            $table->string('dependency_name')->nullable();
            
            $table->date('general_date')->nullable();

            $table->string('reference')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury_account_payable_supplier_checklist_autorization_lists');
    }
};
