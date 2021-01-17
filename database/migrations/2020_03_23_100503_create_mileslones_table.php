<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMileslonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mileslones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_user_id');
            $table->unsignedBigInteger('project_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('start_date')->nullable();
            $table->string('due_date')->nullable();
            $table->string('cost')->default(0);
            $table->text('d_description')->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('mileslones');
    }
}
