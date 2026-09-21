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
        Schema::create('sare_request_review_photos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sare_request_review_id');
            $table->foreign('sare_request_review_id', 'srrp_review_id_foreign')
                ->references('id')->on('sare_request_reviews')->onDelete('cascade');

            $table->string('filename')->nullable();
            $table->unsignedBigInteger('filesize')->nullable();
            $table->text('s3_asset_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sare_request_review_photos');
    }
};
