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
            $table->tinyInteger('is_published')->default(0)->after('terms_n_conditions')->comment("['1'=>'yes','0'=>'no']");
            $table->bigInteger('videohistory_id')->unsigned()->nullable()->after('is_published')->comment("['if video is published then videohistory_id otherwise blank.']");
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
