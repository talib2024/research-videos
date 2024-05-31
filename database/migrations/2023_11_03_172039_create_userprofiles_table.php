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
        Schema::create('userprofiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('account_deletion_request')->nullable()->comment("['1'=>'yes','0'=>'no']");
            $table->timestamp('account_deletion_request_date')->nullable();
            $table->bigInteger('account_deleted_by')->unsigned()->nullable()->comment("['user id of the user, who deleted the account of the user.']");
            $table->timestamp('account_deletion_date')->nullable();
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
        Schema::dropIfExists('userprofiles');
    }
};
