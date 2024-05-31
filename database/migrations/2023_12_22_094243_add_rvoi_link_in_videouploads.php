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
            $table->string('rvoi_link','200')->nullable()->after('currently_assigned_to_editorial_member')->comment("['rvoi link will be generated after video published. Otherwise blank.']");
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
