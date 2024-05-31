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
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('majorcategory_id')->unsigned()->nullable()->comment("['id of majorcategories table.']");
            $table->string('subcategory_name','150')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('subcategories');
    }
};
