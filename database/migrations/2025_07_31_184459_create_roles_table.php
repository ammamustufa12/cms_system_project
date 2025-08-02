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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();        // Role name, e.g. "admin", "manager"
            $table->string('slug')->unique();        // URL friendly
            $table->text('permissions')->nullable(); // JSON or serialized permissions data
            $table->timestamps();
            $table->softDeletes();                   // <-- This line enables soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
