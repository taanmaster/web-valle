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
        Schema::create('fisc_public_event_request_files', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->unsigned()->nullable();
            $table->unsignedBigInteger('fisc_public_event_request_id');
            $table->foreign('fisc_public_event_request_id', 'fisc_per_files_per_id_foreign')
                ->references('id')->on('fisc_public_event_requests')
                ->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('filename')->nullable();
            $table->string('file_extension')->nullable();
            $table->bigInteger('filesize')->nullable();
            $table->text('s3_asset_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fisc_public_event_request_files');
    }
};
