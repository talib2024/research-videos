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
            $table->bigInteger('editorrole_id')->unsigned()->nullable()->after('user_id')->comment("['id of editorroles table. This will be blank, if role is not editor.']");
            $table->bigInteger('majorcategory_id')->unsigned()->nullable()->after('editorrole_id')->comment("['id of majorcategories table. This will be blank, if role is not editor.']");
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
