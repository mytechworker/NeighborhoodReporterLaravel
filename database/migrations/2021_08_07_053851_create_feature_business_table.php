<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureBusinessTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('feature_business', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('business_name', 256);
            $table->text('location');
            $table->text('town');
            $table->text('headline');
            $table->text('message_to_reader');
            $table->string('phone', 50);
            $table->text('website');
            $table->text('address');
            $table->text('header_image');
            $table->text('image');
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
        Schema::dropIfExists('feature_business');
    }

}
