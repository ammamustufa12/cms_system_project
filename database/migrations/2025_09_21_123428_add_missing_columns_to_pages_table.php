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
        Schema::table('pages', function (Blueprint $table) {
            $table->text('content')->nullable()->after('slug');
            $table->text('excerpt')->nullable()->after('content');
            $table->string('meta_title')->nullable()->after('excerpt');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('featured_image')->nullable()->after('meta_description');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('featured_image');
            $table->boolean('is_homepage')->default(false)->after('status');
            $table->integer('sort_order')->default(0)->after('is_homepage');
            $table->json('custom_fields')->nullable()->after('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'content',
                'excerpt', 
                'meta_title',
                'meta_description',
                'featured_image',
                'status',
                'is_homepage',
                'sort_order',
                'custom_fields'
            ]);
        });
    }
};
