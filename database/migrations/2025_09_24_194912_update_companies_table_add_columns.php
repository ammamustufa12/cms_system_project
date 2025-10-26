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
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('companies', 'address')) {
                $table->text('address')->nullable();
            }
            if (!Schema::hasColumn('companies', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('companies', 'email')) {
                $table->string('email')->nullable();
            }
            if (!Schema::hasColumn('companies', 'website')) {
                $table->string('website')->nullable();
            }
            if (!Schema::hasColumn('companies', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['description', 'address', 'phone', 'email', 'website', 'status']);
        });
    }
};
