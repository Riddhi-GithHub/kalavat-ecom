<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('color_cat_id')->nullable();
            $table->unsignedBigInteger('color_product_id')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();

            $table->foreign('color_cat_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('color_product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colors');
    }
}
