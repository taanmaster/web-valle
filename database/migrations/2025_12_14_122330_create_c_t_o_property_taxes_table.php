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
        Schema::create('c_t_o_property_taxes', function (Blueprint $table) {
            $table->id();
            
            // Relación con la propiedad
            $table->foreignId('c_t_o_property_id')->constrained()->onDelete('cascade');
            
            // Información del periodo
            $table->year('tax_year');
            $table->tinyInteger('bimonthly_period')->comment('1-6 para cada bimestre del año');
            
            // Tipo de cuota
            $table->enum('cuota_type', ['cuota_minima', 'cuota_normal']);
            
            // Información del recibo (basado en la imagen)
            $table->date('issue_date')->nullable();
            $table->string('folio')->nullable();
            
            // Valores y pagos
            $table->decimal('property_value', 15, 2)->nullable()->comment('VALOR DEL PREDIO');
            $table->decimal('bimonthly_payment', 15, 2)->nullable()->comment('PAGO BIMESTRAL');
            $table->decimal('tax_rate', 8, 4)->nullable()->comment('TASA');
            
            // Conceptos de pago
            $table->decimal('current_amount', 15, 2)->nullable()->comment('Cve. - Cuenta corriente');
            $table->decimal('arrears_amount', 15, 2)->nullable()->comment('Mov. - Movimientos/Rezagos');
            $table->decimal('effects', 15, 2)->nullable()->comment('EFECTOS');
            
            // Periodo de rezago
            $table->string('arrears_period')->nullable()->comment('PERIODO REZAGO');
            $table->decimal('current_period_amount', 15, 2)->nullable()->comment('PER. CORRIENTE');
            $table->decimal('total_arrears', 15, 2)->nullable()->comment('TOTAL REZAGO');
            $table->decimal('current_account', 15, 2)->nullable()->comment('CTA. CORRIENTE');
            $table->decimal('property_tax_total', 15, 2)->nullable()->comment('TOT. DE IMP. PREDIAL');
            
            // Descuentos y recargos
            $table->decimal('discount', 15, 2)->nullable()->comment('DESCUENTO');
            $table->decimal('surcharges', 15, 2)->nullable()->comment('RECARGOS');
            $table->decimal('surcharges_discount', 15, 2)->nullable()->comment('Descuento RECARGOS');
            $table->decimal('execution_expenses_discount', 15, 2)->nullable()->comment('Descuentos GASTOS DE EJEC');
            
            // Total
            $table->decimal('total_payment', 15, 2)->nullable()->comment('PAGO TOTAL');
            $table->text('total_payment_text')->nullable()->comment('PAGO TOTAL EN LETRA');
            
            // Referencia bancaria
            $table->string('bank_reference')->nullable()->comment('REFERENCIA');
            
            // Estado del pago
            $table->enum('payment_status', ['pendiente', 'pagado', 'vencido'])->default('pendiente');
            $table->date('payment_date')->nullable();
            
            // Notas adicionales
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->index(['c_t_o_property_id', 'tax_year', 'bimonthly_period']);
            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_t_o_property_taxes');
    }
};
