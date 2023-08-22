<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('post_comment', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('comment')->nullable();
            $table->string('type', 100);
            $table->integer('like_count')->nullable();
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
        Schema::dropIfExists('post_comment');
    }

}
