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
        Schema::create('subscriptionplans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name','200')->nullable();
            $table->string('duration','20')->nullable()->comment("['duration will be in days only.']");
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment("['1'=>'active','0'=>'inactive']");
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
        Schema::dropIfExists('subscriptionplans');
    }
};
