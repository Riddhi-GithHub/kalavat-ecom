<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('size_cat_id')->nullable();
            $table->unsignedBigInteger('size_product_id')->nullable();
            $table->string('size')->nullable();
            $table->timestamps();

            $table->foreign('size_cat_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('size_product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sizes');
    }
}
