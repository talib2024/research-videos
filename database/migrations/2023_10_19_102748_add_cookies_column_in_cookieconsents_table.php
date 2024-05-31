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
        Schema::table('cookieconsents', function (Blueprint $table) {
            $table->string('your_privacy_cookie','10')->nullable()->after('cookie_status');
            $table->string('strictly_necessary_cookies','10')->nullable()->after('cookie_status');
            $table->string('performance_cookies','10')->nullable()->after('cookie_status');
            $table->string('functional_cookies','10')->nullable()->after('cookie_status');
            $table->string('targeting_cookies','10')->nullable()->after('cookie_status');
            $table->string('social_media_cookies','10')->nullable()->after('cookie_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cookieconsents', function (Blueprint $table) {
            //
        });
    }
};
