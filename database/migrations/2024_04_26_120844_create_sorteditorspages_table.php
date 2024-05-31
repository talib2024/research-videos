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
        Schema::create('sorteditorspages', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('sorting_option')->default(1)->comment("['1'=>'sort by number','2'=>'sort by name']");
            $table->tinyInteger('order_by')->default(1)->comment("['1'=>'ascending','2'=>'descending']");
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
        Schema::dropIfExists('sorteditorspages');
    }
};
