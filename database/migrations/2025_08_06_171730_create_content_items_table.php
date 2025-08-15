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
        Schema::create('content_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_type_id');
            $table->foreign('content_type_id')->references('id')->on('content_types')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->json('field_data');
            $table->json('meta_data')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->unsignedBigInteger('created_by');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['content_type_id', 'status']);
            $table->index('slug');
            $table->index('status');
            $table->index('published_at');
            $table->index(['content_type_id', 'status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_items');
    }
};
