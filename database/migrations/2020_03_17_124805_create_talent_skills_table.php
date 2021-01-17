<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalentSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talent_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_id');
            $table->unsignedBigInteger('skill_id');
            $table->timestamps();
            $table->foreign('talent_id')->references('id')->on('talents');
            $table->foreign('skill_id')->references('id')->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talent_skills');
    }
}
