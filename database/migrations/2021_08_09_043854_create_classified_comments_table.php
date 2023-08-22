<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassifiedCommentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('classified_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('classified_id')->nullable();
            $table->text('description');
            $table->text('image');
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
        Schema::dropIfExists('classified_comments');
    }

}
