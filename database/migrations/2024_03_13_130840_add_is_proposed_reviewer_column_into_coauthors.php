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
        Schema::table('coauthors', function (Blueprint $table) {
            $table->tinyInteger('is_proposed_reviewer')->after('status')->default(0)->comment("['1'=>'yes','0'=>'no']");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coauthors', function (Blueprint $table) {
            //
        });
    }
};
