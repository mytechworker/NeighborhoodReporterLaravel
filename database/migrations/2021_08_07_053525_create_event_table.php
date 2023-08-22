<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->text('location');
            $table->text('town');
            $table->string('date', 50);
            $table->string('time', 10);
            $table->string('am_pm', 2);
            $table->text('venue');
            $table->string('title', 256);
            $table->text('description');
            $table->text('link');
            $table->text('image');
            $table->integer('intrest_count');
            $table->integer('comment_count');
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
        Schema::dropIfExists('event');
    }

}
