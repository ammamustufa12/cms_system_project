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
        Schema::table('content_types', function (Blueprint $table) {
            $table->json('field_groups')->nullable()->after('style_config');
            $table->json('visibility_rules')->nullable()->after('field_groups');
            $table->string('icon')->nullable()->after('visibility_rules');
            $table->string('color', 7)->nullable()->after('icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_types', function (Blueprint $table) {
            $table->dropColumn(['field_groups', 'visibility_rules', 'icon', 'color']);
        });
    }
};
