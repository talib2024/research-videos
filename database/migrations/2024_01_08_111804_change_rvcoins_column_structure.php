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
            $table->decimal('received_rvcoins', 30, 30)->default(0)->change();
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
            // If you ever need to rollback, you can revert the changes
            $table->decimal('received_rvcoins', 8, 2)->default(0)->change();
        });
    }
};
