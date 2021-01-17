<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeeRatesColumnAdminCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_comission', function (Blueprint $table) {
            $table->float('vat', 8, 2)->default(0);
            $table->float('payment_gateway_fee', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_comission', function (Blueprint $table) {
            $table->dropColumn('payment_gateway_fee');
            $table->dropColumn('vat');
        });
    }
}
