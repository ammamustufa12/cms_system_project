<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create twill_users table
        Schema::create('twill_users', function (Blueprint $table) {
           $table->id();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('username')->unique();
    $table->string('email')->unique();
    $table->string('password', 60)->nullable()->default(null);
    $table->string('phone')->nullable();
    $table->text('address')->nullable();
    $table->string('photo')->nullable();

    $table->unsignedBigInteger('role_id')->nullable();

    $table->rememberToken();
    $table->timestamps();
    $table->softDeletes();

    $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });

        // Create twill_password_resets table
        Schema::create('twill_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('twill_password_resets');
        Schema::dropIfExists('twill_users');
    }
};
