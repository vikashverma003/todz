<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaysHoursColumnToProjectTalentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_talents', function (Blueprint $table) {
            $table->string('no_of_days')->nullable();
            $table->string('no_of_hours')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_talents', function (Blueprint $table) {
            $table->dropColumn('no_of_days');
            $table->dropColumn('no_of_hours');
        });
    }
}
