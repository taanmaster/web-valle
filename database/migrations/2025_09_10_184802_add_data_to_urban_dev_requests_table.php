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
        Schema::table('urban_dev_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('inspector_id')->after('user_id'); // Vinculado a un user_id que tenga el rol inspector
            $table->date('inspection_start_date')->nullable()->after('inspector_id');

            $table->string('inspector_license_number')->nullable()->after('inspection_start_date');

            $table->string('building_type')->nullable()->after('description'); // Opciones posibles: Casa Habitación, Bodega, Local Comercial, Otro

            $table->date('payment_date')->nullable()->after('description');
            $table->string('payment_ref_number_1')->nullable()->after('payment_date');
            $table->string('payment_ref_number_2')->nullable()->after('payment_date');
            $table->string('payment_amount')->nullable()->after('payment_ref_number_2');

            $table->date('inspection_validity_start')->nullable()->after('payment_amount');
            $table->date('inspection_validity_end')->nullable()->after('inspection_validity_start');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('urban_dev_requests', function (Blueprint $table) {
            //
        });
    }
};
