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
        // Lenguaje interno es "Alta de Proveedores", un usuario puede tener muchas altas de proveedores
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            
            // Relación con usuario
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Tipo de persona
            $table->enum('person_type', ['fisica', 'moral'])->default('fisica');
            
            // Número de Alta (alfanumérico único)
            $table->string('registration_number')->unique()->nullable();
            
            // === CAMPOS COMPARTIDOS ===
            
            // Información Fiscal
            $table->string('rfc', 13)->nullable();
            $table->string('email')->nullable();
            
            // Dirección
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code', 10)->nullable();
            
            // Contacto
            $table->string('phone', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->string('nextel_phone', 20)->nullable();
            
            // CAMPOS ESPECÍFICOS PERSONA FÍSICA 
            $table->string('owner_name')->nullable(); // Nombre del propietario
            $table->string('business_name')->nullable(); // Nombre del negocio
            $table->date('activities_start_date')->nullable(); // Fecha de inicio de actividades
            $table->decimal('equity_capital', 15, 2)->nullable(); // Capital contable
            $table->string('curp', 18)->nullable(); // CURP
            $table->string('chamber_registration')->nullable(); // Registro de Cámara
            $table->string('business_line')->nullable(); // Giro
            
            // CAMPOS ESPECÍFICOS PERSONA MORAL 
            $table->string('legal_name')->nullable(); // Razón Social
            $table->text('partners_names')->nullable(); // Nombre de los Socios
            $table->date('incorporation_date')->nullable(); // Fecha de constitución de la sociedad
            $table->decimal('share_capital', 15, 2)->nullable(); // Capital Social
            $table->string('legal_representative')->nullable(); // Apoderado Legal y/o Representantes
            $table->string('legal_representative_curp', 18)->nullable(); // CURP del Representante Legal
            $table->text('shareholders_curp')->nullable(); // CURP de los Accionistas (separados por coma o JSON)
            $table->string('deed_number')->nullable(); // Número de la escritura
            $table->string('notary_name')->nullable(); // Nombre del Notario
            $table->string('predominant_activity')->nullable(); // Actividad del Preponderante
            
            // Estado del alta (flujo: solicitud -> validación -> aprobación -> pago pendiente -> padrón activo)
            $table->enum('status', ['solicitud', 'validacion', 'aprobacion', 'pago_pendiente', 'padron_activo'])->default('solicitud');
            
            // Observaciones y notas
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('user_id');
            $table->index('person_type');
            $table->index('registration_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
