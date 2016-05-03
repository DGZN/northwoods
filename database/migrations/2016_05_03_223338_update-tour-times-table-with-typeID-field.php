<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTourTimesTableWithTypeIDField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_times', function (Blueprint $table) {
            $table->integer('typeID')->after('tierID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tour_times', function (Blueprint $table) {
            $table->dropColumn('typeID');
        });
    }
}
