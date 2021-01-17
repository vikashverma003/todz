<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsTaskRuningColumnToMileslonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mileslones', function (Blueprint $table) {
            $table->integer('is_task_runing')->default(0);
              $table->string('tracker_start_time')->nullable();
            $table->string('runing_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mileslones', function (Blueprint $table) {
          $table->dropColumn('is_task_runing');
           $table->dropColumn('tracker_start_time');
           $table->dropColumn('runing_time');
        });
    }
}
