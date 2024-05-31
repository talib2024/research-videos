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
        Schema::table('userprofiles', function (Blueprint $table) {
            $table->tinyInteger('highest_priority')->after('subcategory_id')->default('0')->comment("['1'=>'highest priorty for editorial member. This will be only for each majorcategory_id','0'=>'normal priority']");
            $table->tinyInteger('visible_status')->after('highest_priority')->default('1')->comment("['1'=>'This editorial member will be visible on the frontend side','0'=>'Not visible']");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('userprofiles', function (Blueprint $table) {
            //
        });
    }
};
