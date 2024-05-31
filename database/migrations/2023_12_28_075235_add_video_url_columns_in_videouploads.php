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
            $table->text('full_video_url')->nullable()->after('uploaded_video');
            $table->text('short_video_url')->nullable()->after('full_video_url');
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
