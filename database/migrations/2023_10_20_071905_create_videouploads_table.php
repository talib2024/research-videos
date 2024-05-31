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
        Schema::create('videouploads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('unique_number','50')->nullable();
            $table->bigInteger('videostatus_id')->nullable();
            $table->bigInteger('videotype_id')->nullable();
            $table->bigInteger('majorcategory_id')->nullable();
            $table->text('video_title')->nullable();
            $table->string('keywords','30')->nullable();
            $table->text('references')->nullable();
            $table->text('abstract')->nullable();
            $table->tinyInteger('declaration_of_interests1')->nullable();
            $table->tinyInteger('declaration_of_interests2')->nullable();
            $table->text('declaration_remark')->nullable();
            $table->tinyInteger('online_publishing_licence')->comment("['1'=>'Open-access','0'=>'Regular']")->nullable();
            $table->text('online_publishing_licence_remark')->nullable();
            $table->string('uploaded_video','300')->nullable();
            $table->tinyInteger('terms_n_conditions')->comment("['1'=>'accepted','0'=>'not accepted']")->nullable();
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
        Schema::dropIfExists('videouploads');
    }
};
