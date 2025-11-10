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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('menu_type')->index(); // sidebar-left, sidebar-right, toolbar, etc.
            $table->string('title');
            $table->string('alias')->nullable();
            $table->string('menu_item_type')->default('url'); // url, page, category, product, custom
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_visible')->default(true);
            $table->string('target_window')->default('_self');
            $table->string('access_level')->default('public');
            $table->json('styling')->nullable();
            $table->json('advanced')->nullable();
            $table->json('mega_menu_settings')->nullable();
            $table->timestamps();
            
            $table->foreign('parent_id')->references('id')->on('menu_items')->onDelete('cascade');
            $table->index(['menu_type', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};


