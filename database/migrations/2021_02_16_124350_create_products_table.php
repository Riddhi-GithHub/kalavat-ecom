<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_id')->nullable();
            $table->string('product_name')->nullable();
            $table->string('images')->nullable();
            $table->string('description')->nullable();
            $table->double('price')->nullable();
            $table->boolean('quantity')->nullable();
            $table->boolean('offer')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('brand')->nullable();
            $table->timestamps();

            $table->foreign('cat_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
