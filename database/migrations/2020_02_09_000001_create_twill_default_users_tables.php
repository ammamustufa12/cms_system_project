<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $twillUsersTable = config('twill.users_table', 'twill_users');

        if (! Schema::hasTable($twillUsersTable)) {
            Schema::create($twillUsersTable, function (Blueprint $table) {
                createDefaultTableFields($table);

                $table->string('name');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();

                $table->string('email')->unique();
                $table->string('password', 60)->nullable()->default(null);

                $table->unsignedBigInteger('role_id')->nullable();
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');

                $table->string('phone', 100)->nullable();
                $table->date('joining_date')->nullable();
                $table->json('skills')->nullable();
                $table->string('designation', 255)->nullable();

                $table->string('website')->nullable();
                $table->string('city')->nullable();
                $table->string('country')->nullable();
                $table->string('zipcode', 10)->nullable();

                $table->string('github_username')->nullable();
                $table->string('dribbble_username')->nullable();
                $table->string('pinterest_username')->nullable();
                $table->string('portfolio_website')->nullable();

                $table->string('photo')->nullable(); // Profile image
                $table->string('cover_image')->nullable();

                $table->string('title', 255)->nullable();
                $table->text('description')->nullable();
                $table->rememberToken();
            });
        }

        $twillPasswordResetsTable = config('twill.password_resets_table', 'twill_password_resets');

        if (! Schema::hasTable($twillPasswordResetsTable)) {
            Schema::create($twillPasswordResetsTable, function (Blueprint $table) {
                $table->string('email')->index();
                $table->string('token')->index();
                $table->timestamp('created_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $twillUsersTable = config('twill.users_table', 'twill_users');

        if (Schema::hasTable($twillUsersTable)) {
            Schema::table($twillUsersTable, function (Blueprint $table) {
                $table->dropForeign(['role_id']);
            });
        }

        Schema::dropIfExists(config('twill.password_resets_table', 'twill_password_resets'));
        Schema::dropIfExists($twillUsersTable);
    }
};
