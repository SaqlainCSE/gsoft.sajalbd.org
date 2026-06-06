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
        Schema::create('booking_payment_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id');
            $table->string('payment');
            $table->string('payment_info');
            $table->string('reference')->nullable();
            $table->double('amount');
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
        Schema::dropIfExists('booking_payment_infos');
    }
};
