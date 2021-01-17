<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->comment('Todz_id');
            $table->string('transcript_id')->nullable();
            $table->string('test_id')->nullable();
            $table->string('test_name')->nullable();
            $table->string('percentage')->nullable();
            $table->string('percentile')->nullable();
            $table->string('average_score')->nullable();
            $table->string('test_result')->nullable();
            $table->string('time')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_results');
    }
}
