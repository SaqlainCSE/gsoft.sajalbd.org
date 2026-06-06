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
        Schema::create('booking_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id');
            $table->foreignId('product_id');
            $table->double('weight');
            $table->double('unit_price');
            $table->double('wage');
            $table->double('vat_amount')->nullable();
            $table->double('total')->nullable();
            $table->double('st_dia')->nullable();
            $table->double('st_dia_price')->nullable();
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
        Schema::dropIfExists('booking_metas');
    }
};
