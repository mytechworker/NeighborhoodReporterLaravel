<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassifiedTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('classified', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->text('location');
            $table->text('town');
            $table->string('category',100);
            $table->string('title', 256);
            $table->text('description');
            $table->text('image');
            $table->integer('like_count')->nullable();
            $table->integer('comment_count')->nullable();
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
        Schema::dropIfExists('classified');
    }

}
