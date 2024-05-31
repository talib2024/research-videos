<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watchlaterlists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable()->comment("['user id, who will check in watch later option']");
            $table->bigInteger('videoupload_id')->unsigned()->nullable()->comment("['video id, which one is added in watch later option']");
            $table->tinyInteger('type')->nullable()->comment("['1'=>'added in watch later','0'=>'Removed from watch later']");
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
        Schema::dropIfExists('watchlaterlists');
    }
};
