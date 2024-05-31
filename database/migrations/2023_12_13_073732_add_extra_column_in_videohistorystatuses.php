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
        Schema::table('videohistorystatuses', function (Blueprint $table) {
            $table->string('text_to_show_on_history','200')->nullable()->after('option_show_to_role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videohistorystatuses', function (Blueprint $table) {
            //
        });
    }
};
