<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Videos',function(Blueprint $table)
        {
            $table->primary('id');
            $table->string('id');
            $table->string('title');
            $table->string('thumbnail');
            $table->text('description');
            $table->string('idYoutuber');
            $table->foreign('idYoutuber')->references('id')->on('Youtuber');
            $table->string('url');
            $table->date('publishedAt');
            $table->date('updatedAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
