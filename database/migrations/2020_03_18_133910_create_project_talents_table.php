<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTalentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_talents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_user_id');
            $table->unsignedBigInteger('project_id');
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->foreign('talent_user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_talents');
    }
}
