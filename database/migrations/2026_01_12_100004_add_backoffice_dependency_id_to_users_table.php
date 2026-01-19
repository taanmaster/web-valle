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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('backoffice_dependency_id')
                  ->nullable()
                  ->after('remember_token')
                  ->constrained('backoffice_dependencies')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['backoffice_dependency_id']);
            $table->dropColumn('backoffice_dependency_id');
        });
    }
};
