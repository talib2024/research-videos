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
        Schema::create('likeunlikecounters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable()->comment("['user id, who did like or unlike']");
            $table->bigInteger('videoupload_id')->unsigned()->nullable()->comment("['video id, which one is done as like or unlike']");
            $table->tinyInteger('type')->nullable()->comment("['1'=>'like','0'=>'unlike']");
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
        Schema::dropIfExists('likeunlikecounters');
    }
};
