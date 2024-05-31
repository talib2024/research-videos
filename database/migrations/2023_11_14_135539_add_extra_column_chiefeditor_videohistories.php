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
            $table->tinyInteger('last_record_for_chief_editor')->default(0)->after('reviewer_email')->comment("['1'=>'yes','0'=>'no']");
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
