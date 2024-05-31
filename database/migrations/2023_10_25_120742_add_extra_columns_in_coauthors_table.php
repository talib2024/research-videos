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
            $table->string('phone','20')->nullable()->after('email');
            $table->bigInteger('country_id')->unsigned()->nullable()->after('role');
            $table->string('city','50')->nullable()->after('country_id');
            $table->string('zip_code','15')->nullable()->after('city');
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
