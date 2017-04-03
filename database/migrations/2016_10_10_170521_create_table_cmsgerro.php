<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCmsgerro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Modules: articles - GOTOWE*/
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id')->index();
            $table->integer('user_id')->unsigned();
            $table->string('image');
            $table->string('subject')->unique();
            $table->string('slug')->index();
            $table->string('description');
            $table->integer('position');
            $table->boolean('active');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        /* Modules: articles - GOTOWE*/
        Schema::create('category', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id')->index();
            $table->string('name')->unique();
            $table->string('slug');
            $table->string('description');
        });
        /* Modules: articles - GOTOWE*/
        Schema::create('post-category', function($table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
        });
        /* Modules: albums - GOTOWE */
        Schema::create('media-albums', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable(); //wartosc null jest glowna
            $table->string('name')->unique();
            $table->string('url');
            $table->string('slug')->index();
            $table->boolean('active');
            $table->string('type',150);
            $table->integer('position');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('set null');
        });
        /* Modules: files with media albums - GOTOWE */
        Schema::create('files', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('album_id')->unsigned()->index();
            $table->string('name');
            $table->string('url');
            $table->boolean('active');
            $table->string('option',10); // domyslnie gallery, video, music
            $table->integer('position');
            $table->foreign('album_id')->references('id')->on('media-albums')->onDelete('cascade');
        }); 
        /* Name menu - sites - GOTOWE*/
        Schema::create('pages', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug')->unique()->index();
            $table->string('title');
            $table->string('description');
            $table->string('keyword');
            $table->boolean('robots');
            $table->boolean('active');
            $table->integer('position');
            $table->integer('category_id')->unsigned()->nullable(); 
            $table->boolean('is_widgets');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('set null');
        });
        /* GOTOWE */
        Schema::create('pages-modules', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('page_id')->unsigned();
            $table->integer('module');
            $table->integer('position');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });

        /* Modules
        * 1 - articles
        * 2 - media with albums
        * 3 - media single
        * 4 - cookies
        * 5 - contact
        */
    
        Schema::create('widgets', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('name');
            $table->boolean('active');
            $table->integer('position');
            $table->string('file');
        });

        /* Modules: media single */

        Schema::create('media-single', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('name');
            $table->string('url');
            $table->integer('category_id')->unsigned()->nullable();
            $table->boolean('active');
            $table->string('type',150);
            $table->integer('position');
            $table->string('option',10);
            $table->foreign('category_id')->references('id')->on('category')->onDelete('set null');
        }); 

        /* Templates */
        Schema::create('templates', function (Blueprint $table) {
            $table->engine = "MyISAM";
            $table->increments('id')->index();
            $table->string('name')->unique();
            $table->string('folder')->index();
        }); 


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
        Schema::drop('category');
        Schema::drop('post-category');
        Schema::drop('pages');
        Schema::drop('widgets');
        Schema::drop('pages-modules');
        Schema::drop('gallerie-images');
        Schema::drop('gallerie-albums');
        Schema::drop('gallerie-one');
        Schema::drop('templates');
    }
}
