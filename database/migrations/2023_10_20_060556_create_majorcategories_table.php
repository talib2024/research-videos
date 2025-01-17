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
        Schema::create('majorcategories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name','50')->nullable();
            $table->tinyInteger('sequence')->nullable();
            $table->tinyInteger('status')->default('1')->comment("['1'=>'active','0'=>'inactive']");
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
        Schema::dropIfExists('majorcategories');
    }
};
