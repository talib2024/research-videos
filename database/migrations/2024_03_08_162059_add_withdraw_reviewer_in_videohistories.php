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
            $table->tinyInteger('withdraw_reviewer')->after('reviewer_email')->default(0)->comment("['1'=>'yes','0'=>'no','If editorial member wants to withdraw from the existing reviewer']");
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
