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
        Schema::create('coauthors', function (Blueprint $table) {
            $table->id();
            $table->string('name','50')->nullable();
            $table->string('surname','50')->nullable();
            $table->string('email','50')->nullable();
            $table->string('institute_name','150')->nullable();
            $table->string('role','50')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('coauthors');
    }
};
