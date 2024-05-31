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
        Schema::table('videouploads', function (Blueprint $table) {
            $table->tinyInteger('withdraw_video')->after('doi_link')->default(0)->comment("['1'=>'yes','0'=>'no','If corresponding author wants to withdraw the video.']");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videouploads', function (Blueprint $table) {
            //
        });
    }
};
