<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
     public function up()
    {
        $twillRelatedTable = config('twill.related_table', 'twill_related');

        if (!Schema::hasTable($twillRelatedTable)) {
            Schema::create($twillRelatedTable, function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('subject_id')->nullable();
                $table->string('subject_type', 100);
                $table->unsignedInteger('related_id')->nullable();
                $table->string('related_type', 100);
                $table->string('browser_name', 100)->index();
                $table->unsignedInteger('position');
            });

            DB::statement("ALTER TABLE `$twillRelatedTable` ADD UNIQUE `related_unique` (`subject_id`, `subject_type`(50), `related_id`, `related_type`(50), `browser_name`(50))");
        }
    }
    

    public function down()
    {
        $twillRelatedTable = config('twill.related_table', 'twill_related');
        Schema::dropIfExists($twillRelatedTable);
    }
};
