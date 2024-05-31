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
        Schema::table('rvcoins', function (Blueprint $table) {
            $table->bigInteger('rvcoinsrewardtype_id')->unsigned()->nullable()->after('user_id');
            $table->text('description')->nullable()->after('received_rvcoins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rvcoins', function (Blueprint $table) {
            //
        });
    }
};
