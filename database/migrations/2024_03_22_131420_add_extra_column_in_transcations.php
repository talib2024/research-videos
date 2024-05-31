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
        Schema::table('transcations', function (Blueprint $table) {
            $table->string('transaction_type', 20)->comment("['wire_transfer', 'paypal', 'rv_coins', 'assign_by_admin','assign_to_institute_by_admin']")->change();
            $table->string('email_type','100')->after('ip_address')->nullable();
            $table->tinyInteger('is_active')->after('email_type')->default(0)->comment("['1'=>'yes, if assign_to_institute_by_admin checked','0'=>'no, if assign_to_institute_by_admin not checked']");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transcations', function (Blueprint $table) {
            //
        });
    }
};
