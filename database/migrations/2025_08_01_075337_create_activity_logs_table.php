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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
               $table->unsignedBigInteger('user_id')->nullable(); // jisne action kiya
        $table->string('action'); // example: created, updated, deleted
        $table->string('model_type')->nullable(); // kis model pe action hua
        $table->unsignedBigInteger('model_id')->nullable(); // us model ka ID
        $table->text('description')->nullable(); // aur details
        $table->json('changes')->nullable(); // changes (before/after)
        $table->ipAddress('ip_address')->nullable(); // IP address
        $table->string('user_agent')->nullable(); // browser info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
