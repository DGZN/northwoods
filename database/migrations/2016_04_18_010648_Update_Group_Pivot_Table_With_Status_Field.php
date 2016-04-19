<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGroupPivotTableWithStatusField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_pivot', function (Blueprint $table) {
            $table->boolean('status')->after('customerID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_pivot', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
