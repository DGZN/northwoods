<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomersTableWithAddressCityZipCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('country')->after('email');
            $table->string('zip')->after('email');
            $table->string('state')->after('email');
            $table->string('city')->after('email');
            $table->string('address')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('zip');
            $table->dropColumn('country');
        });
    }
}
