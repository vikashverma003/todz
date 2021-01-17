<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCorporateUserNewCoulmns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('location')->nullable();
            $table->string('company_address')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('vat_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('location');
            $table->dropColumn('company_address');
            $table->dropColumn('registration_number');
            $table->dropColumn('vat_details');
        });
    }
}
