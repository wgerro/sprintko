<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGeneral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('articles_count');
            $table->string('api');
            $table->string('logo');
            $table->string('google_verification');
            $table->boolean('category_widgets')->default(true);
            $table->boolean('article_widgets')->default(true);
            $table->boolean('gallery_widgets')->default(true);
            $table->boolean('search_widgets')->default(true);
            $table->boolean('error_widgets')->default(true);
            $table->boolean('is_comments')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('general');
    }
}
