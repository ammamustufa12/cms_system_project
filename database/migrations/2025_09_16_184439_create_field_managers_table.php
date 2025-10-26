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
        Schema::create('field_managers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('type')->default('text'); // text, textarea, email, number, select, etc.
            $table->json('field_config')->nullable(); // field configuration options
            $table->json('validation_rules')->nullable(); // validation rules
            $table->string('source')->default('local'); // local, centralized, custom
            $table->string('version')->nullable();
            $table->string('author')->nullable();
            $table->text('install_instructions')->nullable();
            $table->json('dependencies')->nullable(); // required dependencies
            $table->boolean('is_active')->default(true);
            $table->boolean('is_installed')->default(false);
            $table->string('install_file_path')->nullable(); // path to zip file
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index('slug');
            $table->index('type');
            $table->index('source');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_managers');
    }
};
