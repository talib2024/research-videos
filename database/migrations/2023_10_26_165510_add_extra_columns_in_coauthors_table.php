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
            $table->bigInteger('authortype_id')->unsigned()->nullable()->after('user_id');
            $table->string('affiliation','100')->nullable()->after('institute_name');
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
