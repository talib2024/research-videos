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
        Schema::table('sorteditorspages', function (Blueprint $table) {
            $table->tinyInteger('editorial_member_per_page')->default(1)->after('order_by')->comment("['adjust editorial member per page for editorial board']");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sorteditorspages', function (Blueprint $table) {
            //
        });
    }
};
