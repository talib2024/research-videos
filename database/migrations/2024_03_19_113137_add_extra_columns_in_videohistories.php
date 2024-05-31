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
            $table->tinyInteger('is_latest_record_for_reviewer_from_editor')->after('last_record_for_chief_editor')->default(0)->comment("['1'=>'yes','0'=>'no']");
            $table->tinyInteger('review_action_by_reviewer')->after('is_latest_record_for_reviewer_from_editor')->default(0)->comment("['1'=>'If reviewer takes action accept or deny','0'=>'If reviewer does not take any action']");
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
