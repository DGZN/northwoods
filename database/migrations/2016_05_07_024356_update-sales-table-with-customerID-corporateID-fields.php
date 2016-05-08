<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSalesTableWithCustomerIDCorporateIDFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('corporateID')->after('employeeID')->after('employeeID');
            $table->integer('customerID')->after('employeeID')->after('employeeID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('corporateID');
            $table->dropColumn('customerID');
        });
    }
}
