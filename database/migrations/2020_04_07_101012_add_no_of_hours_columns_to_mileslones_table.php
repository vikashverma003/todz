<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoOfHoursColumnsToMileslonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mileslones', function (Blueprint $table) {
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
        Schema::table('mileslones', function (Blueprint $table) {
            $table->dropColumn('no_of_hours');
        });
    }
}
