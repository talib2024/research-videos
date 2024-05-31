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
            $table->string('last_name','100')->nullable()->after('name');
            $table->string('phone','20')->nullable()->after('last_name');
            $table->bigInteger('country_id')->unsigned()->nullable()->after('password');
            $table->string('city','50')->nullable()->after('country_id');
            $table->string('zip_code','15')->nullable()->after('city');
            $table->string('institute_name','150')->nullable()->after('zip_code');
            $table->text('address')->nullable()->after('zip_code');
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
