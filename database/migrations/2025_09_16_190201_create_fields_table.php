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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // Display name like "Street Address"
            $table->string('alias'); // Database name like "street"
            $table->string('type'); // text, dropdown, email, mask, etc.
            $table->unsignedBigInteger('field_group_id')->nullable();
            $table->text('description')->nullable();
            $table->json('field_config')->nullable(); // field configuration options
            $table->json('validation_rules')->nullable(); // validation rules
            $table->string('viewable')->default('public'); // public, private, restricted
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->foreign('field_group_id')->references('id')->on('field_groups')->onDelete('set null');
            $table->index('field_group_id');
            $table->index('type');
            $table->index('is_active');
            $table->index('alias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
