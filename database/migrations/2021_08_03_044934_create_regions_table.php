<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('region_code', 2);
            $table->string('name');
            $table->string('status')->default('Active');
            $table->softDeletes();
            $table->timestamps();
        });
        $path = base_path().'/database/seeds/sql/regions.sql';
        $sql = file_get_contents($path);
        \Illuminate\Support\Facades\DB::unprepared($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('religionals');
    }
}
