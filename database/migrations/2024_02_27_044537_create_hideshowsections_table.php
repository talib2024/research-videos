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
        Schema::create('hideshowsections', function (Blueprint $table) {
            $table->id();
            $table->string('section_name','100')->nullable();
            $table->tinyInteger('status')->default(0)->comment("['1'=>'show','0'=>'hide']");
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
        Schema::dropIfExists('hideshowsections');
    }
};
