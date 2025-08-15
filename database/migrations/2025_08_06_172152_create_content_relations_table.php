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
        Schema::create('content_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_item_id');
            $table->unsignedBigInteger('to_item_id');
            $table->string('relation_type');
            $table->json('relation_data')->nullable();
            $table->timestamps();

            $table->foreign('from_item_id')->references('id')->on('content_items')->onDelete('cascade');
            $table->foreign('to_item_id')->references('id')->on('content_items')->onDelete('cascade');

            $table->index(['from_item_id', 'relation_type']);
            $table->index(['to_item_id', 'relation_type']);

            $table->unique(['from_item_id', 'to_item_id', 'relation_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_relations');
    }
};
