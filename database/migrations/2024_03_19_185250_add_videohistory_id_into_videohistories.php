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
        Schema::table('videohistories', function (Blueprint $table) {
            $table->bigInteger('videohistory_id')->unsigned()->after('review_action_by_reviewer')->default(0)->comment("['If reviewer takes action accept or deny']");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videohistories', function (Blueprint $table) {
            //
        });
    }
};
