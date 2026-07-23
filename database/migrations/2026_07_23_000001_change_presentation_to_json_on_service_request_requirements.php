<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Conservar los valores existentes como arreglo de un solo elemento
        $existing = DB::table('service_request_requirements')
            ->whereNotNull('presentation')
            ->where('presentation', '!=', '')
            ->pluck('presentation', 'id');

        Schema::table('service_request_requirements', function (Blueprint $table) {
            $table->dropColumn('presentation');
        });

        Schema::table('service_request_requirements', function (Blueprint $table) {
            // La presentación admite varias opciones (Original, Copia, Digital)
            $table->json('presentation')->nullable()->after('name');
        });

        foreach ($existing as $id => $value) {
            DB::table('service_request_requirements')
                ->where('id', $id)
                ->update(['presentation' => json_encode([$value])]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $existing = DB::table('service_request_requirements')
            ->whereNotNull('presentation')
            ->pluck('presentation', 'id');

        Schema::table('service_request_requirements', function (Blueprint $table) {
            $table->dropColumn('presentation');
        });

        Schema::table('service_request_requirements', function (Blueprint $table) {
            $table->string('presentation')->nullable()->after('name');
        });

        foreach ($existing as $id => $value) {
            $decoded = json_decode($value, true);
            DB::table('service_request_requirements')
                ->where('id', $id)
                ->update(['presentation' => is_array($decoded) ? ($decoded[0] ?? null) : $value]);
        }
    }
};
