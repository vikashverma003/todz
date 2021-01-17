<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilestoneTimeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestone_time_logs', function (Blueprint $table) {
            $table->id();
            $table->string('milestone_id');
            $table->string('project_id');
            $table->string('talent_user_id');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('total_time')->nullable();
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
        Schema::dropIfExists('milestone_time_logs');
    }
}
