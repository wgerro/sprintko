<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });

        Schema::create('page_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file', 50);
            $table->integer('content_id')->unsigned();
            $table->integer('page_id')->unsigned()->nullable();
            $table->string('page_str', 20);
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contents');
        Schema::drop('page_contents');
    }
}
