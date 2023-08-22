<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->integer('post_author')->nullable();
            $table->timestamp('post_date')->nullable();
            $table->timestamp('post_date_gmt')->nullable();
            $table->text('location');
            $table->text('town');
            $table->text('post_title');
            $table->text('post_subtitle');
            $table->text('post_content');
            $table->text('post_image');
            $table->string('post_category', 100);
            $table->string('post_type', 100);
            $table->string('post_status', 100);
            $table->text('guid');
            $table->integer('like_count');
            $table->integer('comment_count');
            $table->string('post_report', 100)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('post');
    }

}
