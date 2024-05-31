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
        Schema::create('videohistorystatuses', function (Blueprint $table) {
            $table->id();
            $table->string('option_description','200')->nullable();
            $table->string('option','200')->nullable()->comment("['This will show on frontend side with options']");
            $table->string('option_show_to_role','100')->nullable()->comment("['option will be shown frontend by this condition']");
            $table->string('is_option_to_show_first_time','10')->nullable();
            $table->string('status','100')->nullable()->comment("['This is specific status to show on frontend side']");
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
        Schema::dropIfExists('videohistorystatuses');
    }
};
