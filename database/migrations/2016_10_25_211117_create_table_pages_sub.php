<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePagesSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page-sub', function($table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('page_id')->unsigned()->nullable();
            $table->integer('page_sub_id')->unsigned()->index();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('page-sub');
    }
}
