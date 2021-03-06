<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CopyaPostMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function(Blueprint $table){
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->string('featured_image')->nullable();
<<<<<<< HEAD
            $table->timestamp('published_at')->nullable();
=======
            $table->timestamp('published_at');
>>>>>>> dcd9dd4007d0d0e4125aab954f13ea73807b102f
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category_post', function(Blueprint $table){
            $table->increments('id');
            $table->integer('post_id');
            $table->integer('category_id');
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
        Schema::drop('posts');
        Schema::drop('category_post');
    }
}
