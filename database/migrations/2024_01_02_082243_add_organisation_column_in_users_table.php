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
        Schema::table('users', function (Blueprint $table) {
            $table->string('is_organization', 255)->comment("['1'=>'Account of the main organisation','2'=>'Account of employee of the main organisation','0'=>'Not related to any organisation']")->change();
            $table->bigInteger('related_main_organisation_id')->nullable()->after('is_organization')->comment("['user id of the related organisation. If is_organization value is 2 only']");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
