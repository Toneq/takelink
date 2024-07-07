<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movie_info_genres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_info_id');
            $table->unsignedBigInteger('genre_id');
            $table->foreign('movie_info_id')->references('id')->on('movies_info')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movie_info_genres');
    }
};
