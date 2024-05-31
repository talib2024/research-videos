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
            $table->bigInteger('membershipplan_id')->unsigned()->nullable()->after('uploaded_video');
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
