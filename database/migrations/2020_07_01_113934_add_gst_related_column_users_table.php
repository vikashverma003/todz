<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGstRelatedColumnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('invoice_country_code')->nullable();
            $table->string('country_of_operation')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->string('gst_vat_applicable')->nullable();
            $table->string('vat_gst_number')->nullable();
            $table->string('vat_gst_rate')->nullable();
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
            $table->dropColumn('invoice_country_code');
            $table->dropColumn('country_of_operation');
            $table->dropColumn('country_of_origin');
            $table->dropColumn('gst_vat_applicable');
            $table->dropColumn('vat_gst_number');
            $table->dropColumn('vat_gst_rate');
        });
    }
}
