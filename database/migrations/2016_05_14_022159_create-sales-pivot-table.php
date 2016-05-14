<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_pivot', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('saleID');
          $table->integer('productID');
          $table->integer('qty');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sale_pivot');
    }
}
