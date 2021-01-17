<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->string('payment_type');
            $table->unsignedBigInteger('charge_from_card_id')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->string('amount')->default(0);
            $table->string('fees')->default(0);
            $table->string('transaction_id');
            $table->text('response_json')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
