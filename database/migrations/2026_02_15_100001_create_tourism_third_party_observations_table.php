<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tourism_third_party_observations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tourism_third_party_request_id')
                ->constrained('tourism_third_party_requests', 'id', 'ttp_obs_request_fk')
                ->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('observation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tourism_third_party_observations');
    }
};
