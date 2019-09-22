<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_image', function (Blueprint $table) {

            $table->bigIncrements('id')->unsigned();



            $table->bigInteger('album_id')->unsigned();
            $table->bigInteger('image_id')->unsigned();


            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');

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
        Schema::dropIfExists('album_image');
    }
}
