<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->foreignId('guia_categoria_id')->nullable()->constrained('guia_categorias')->nullOnDelete();
            $table->string('dependencia')->nullable();
            $table->boolean('mostrar_front')->default(false);
            $table->boolean('mostrar_admin')->default(false);
            $table->boolean('destacada')->default(false);
            $table->date('fecha_entrada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guias');
    }
};
