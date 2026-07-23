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
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn('modalities');
        });

        Schema::table('service_requests', function (Blueprint $table) {
            // La modalidad es de selección única
            $table->string('modality')->nullable()->after('responsible_subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn('modality');
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->json('modalities')->nullable();
        });
    }
};
