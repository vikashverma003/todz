<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnlineTestColumnToTalentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talents', function (Blueprint $table) {
            $table->integer('is_profile_screened')->default(0);
            $table->integer('is_aptitude_test')->default(0);
            $table->integer('is_technical_test')->default(0);
            $table->integer('is_interview')->default(0);
            $table->string('aptitude_test_id')->nullable();
            $table->string('technical_test_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talents', function (Blueprint $table) {
            $table->$table->dropColumn('is_profile_screened');
            $table->$table->dropColumn('is_aptitude_test');
            $table->$table->dropColumn('is_technical_test');
            $table->$table->dropColumn('is_interview');
            $table->$table->dropColumn('aptitude_test_id');
            $table->$table->dropColumn('technical_test_id');
        });
    }
}
