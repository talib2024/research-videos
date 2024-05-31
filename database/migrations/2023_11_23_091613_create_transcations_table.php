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
        Schema::create('transcations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('item_type','20')->nullable()->comment("['video', 'subscription' only]");
            $table->bigInteger('item_id')->unsigned()->nullable()->comment("['Either videoupload_id or subscriptionplan_id based on the type of transaction']");
            $table->decimal('amount', 10, 2);
            $table->timestamp('subscription_start_date')->nullable()->comment("['For subscription type only]");
            $table->timestamp('subscription_end_date')->nullable()->comment("['For subscription type only]");
            $table->string('transaction_id','200')->nullable()->comment("['Transaction id of done payment]");
            $table->string('transaction_type','20')->nullable()->comment("['wire_transfer', 'paypal', 'credit_card']");
            $table->string('transaction_receipt','200')->nullable()->comment("['For transaction wire_transfer only']");
            $table->tinyInteger('is_payment_done')->default(0)->comment("['1'=>'yes','0'=>'no']");
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
        Schema::dropIfExists('transcations');
    }
};
