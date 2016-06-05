<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductModifierPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_modifier_pivots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productID');
            $table->integer('productModifierGroupID');
            $table->integer('productModifierID');
            $table->float('price');
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
        Schema::drop('product_modifier_pivots');
    }
}
