<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class YoutuberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Youtuber',function(Blueprint $table)
        {
            $table->primary('id');
            $table->string('id');
            $table->string('name');
            $table->string('description');
            $table->string('nrSubs');
            $table->date('createdAt');
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
