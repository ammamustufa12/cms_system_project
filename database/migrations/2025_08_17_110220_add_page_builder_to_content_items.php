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
        Schema::table('content_items', function (Blueprint $table) {
            // Add page builder fields if they don't exist
            if (!Schema::hasColumn('content_items', 'page_builder_html')) {
                $table->longText('page_builder_html')->nullable()->after('field_data');
            }
            if (!Schema::hasColumn('content_items', 'page_builder_css')) {
                $table->longText('page_builder_css')->nullable()->after('page_builder_html');
            }
            if (!Schema::hasColumn('content_items', 'page_builder_components')) {
                $table->json('page_builder_components')->nullable()->after('page_builder_css');
            }

            // Add some additional useful fields
            if (!Schema::hasColumn('content_items', 'layout_template')) {
                $table->string('layout_template')->nullable()->after('page_builder_components')->default('default');
            }
            if (!Schema::hasColumn('content_items', 'seo_title')) {
                $table->string('seo_title')->nullable()->after('layout_template');
            }
            if (!Schema::hasColumn('content_items', 'seo_description')) {
                $table->text('seo_description')->nullable()->after('seo_title');
            }
            if (!Schema::hasColumn('content_items', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('seo_description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->dropColumn([
                'page_builder_html',
                'page_builder_css',
                'page_builder_components',
                'layout_template',
                'seo_title',
                'seo_description',
                'featured_image'
            ]);
        });
    }
};
