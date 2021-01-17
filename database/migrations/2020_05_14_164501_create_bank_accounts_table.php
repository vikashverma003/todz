<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('mangopay_account_id');
            $table->string('is_default')->default(0);
            $table->string('bank_id')->nullable();
            $table->text('response')->nullable();
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('mangopay_account_id')->references('id')->on('mangopay_accounts');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
}
