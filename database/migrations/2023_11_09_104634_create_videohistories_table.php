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
        Schema::create('videohistories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('videoupload_id')->unsigned()->nullable();
            $table->bigInteger('videohistorystatus_id')->unsigned()->nullable();
            $table->bigInteger('send_from_user_id')->unsigned()->nullable();
            $table->bigInteger('send_to_user_id')->unsigned()->nullable();
            $table->text('message')->nullable();
            $table->tinyInteger('is_first_time_pass_video')->nullable();
            $table->bigInteger('accepted_by_editorial_member_id')->unsigned()->nullable();
            $table->bigInteger('declined_by_editorial_member_id')->unsigned()->nullable();
            $table->bigInteger('accepted_by_reviewer_id')->unsigned()->nullable();
            $table->bigInteger('declined_by_reviewer_id')->unsigned()->nullable();
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
        Schema::dropIfExists('videohistories');
    }
};
