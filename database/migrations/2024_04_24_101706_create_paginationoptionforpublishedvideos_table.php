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
        Schema::create('paginationoptionforpublishedvideos', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('video_items_per_page')->default(1)->comment("['adjust video items per page for published videos']");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paginationoptionforpublishedvideos');
    }
};
