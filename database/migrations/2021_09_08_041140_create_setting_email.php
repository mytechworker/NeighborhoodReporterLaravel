<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_email', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('community_id');
            $table->boolean('daily_news')->default(false);
            $table->boolean('breacking_news')->default(false);
            $table->boolean('community_cal')->default(false);
            $table->boolean('neighbor_posts')->default(false);
            $table->boolean('classifieds')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('setting_email');
    }
}
