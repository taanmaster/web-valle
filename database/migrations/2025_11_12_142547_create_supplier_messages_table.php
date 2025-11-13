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
        Schema::create('supplier_messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // Perfil de Usuario donde se mostrará el mensaje (Usuario con Rol Proveedor)
            $table->unsignedBigInteger('supplier_id'); // Alta de Proveedor a la que esta asociado el mensaje
            $table->longText('message');
            $table->string('status')->default('unread'); // Estados: unread, read, archived

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_messages');
    }
};
