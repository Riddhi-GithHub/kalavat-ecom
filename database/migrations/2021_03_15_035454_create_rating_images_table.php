<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rating_id')->nullable();
            $table->string('images')->nullable();
            $table->timestamps();
            
            $table->foreign('rating_id')->references('id')->on('ratings')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_images');
    }
}
