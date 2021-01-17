<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_ratings', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->default(0);
            $table->integer('rating')->default(1);
            $table->string('feedback')->nullable();
            $table->integer('given_by_user_id')->default(0);
            $table->integer('rated_user_id')->default(0);
            $table->string('rating_given_by')->nullable();
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
        Schema::dropIfExists('project_ratings');
    }
}
