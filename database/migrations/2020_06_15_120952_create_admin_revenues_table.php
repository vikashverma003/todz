<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_revenues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->default(0);
            $table->unsignedBigInteger('from_user_id')->default(0);
            $table->string('amount')->default(0);
            $table->string('transaction_id')->nullable();
            $table->text('transaction_response')->nullable();
            $table->string('commission_from')->nullable();
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
        Schema::dropIfExists('admin_revenues');
    }
}
