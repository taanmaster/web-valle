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
        Schema::table('citizen_complains', function (Blueprint $table) {

            $table->boolean('is_agree')->default(false)->nullable();
            $table->boolean('is_aware')->default(false)->nullable();
            $table->string('ine')->nullable();
            $table->boolean('anonymus')->default(false)->nullable();
            $table->string('suburb')->nullable();
            $table->string('town')->nullable();
            $table->boolean('notification_email')->default(false)->nullable();
            $table->boolean('notification_home')->default(false)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizen_complains', function (Blueprint $table) {

            $table->dropColumn('is_agree');
            $table->dropColumn('is_aware');

        });
    }
};
