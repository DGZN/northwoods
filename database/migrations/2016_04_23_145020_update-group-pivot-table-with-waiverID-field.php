<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGroupPivotTableWithWaiverIDField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_pivot', function (Blueprint $table) {
            $table->integer('waiverStatus')->after('status');
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
            $table->dropColumn('waiverStatus');
        });
    }
}
