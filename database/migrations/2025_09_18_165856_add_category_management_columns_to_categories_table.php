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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->text('description')->nullable()->after('name');
            $table->string('slug')->unique()->after('description');
            $table->foreignId('category_group_id')->constrained()->onDelete('cascade')->after('slug');
            $table->boolean('is_active')->default(true)->after('category_group_id');
            $table->integer('sort_order')->default(0)->after('is_active');
            $table->string('color', 7)->nullable()->after('sort_order');
            $table->string('icon')->nullable()->after('color');
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade')->after('icon');
            $table->string('meta_title')->nullable()->after('parent_id');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['category_group_id']);
            $table->dropForeign(['parent_id']);
            $table->dropColumn([
                'name', 'description', 'slug', 'category_group_id', 
                'is_active', 'sort_order', 'color', 'icon', 'parent_id',
                'meta_title', 'meta_description', 'meta_keywords', 'deleted_at'
            ]);
        });
    }
};
