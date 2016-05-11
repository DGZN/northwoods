<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGroupPivotTableWithTermsStatusField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_pivot', function (Blueprint $table) {
            $table->integer('termsStatus')->after('waiverStatus');
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
          $table->dropColumn('termsStatus');
        });
    }
}
