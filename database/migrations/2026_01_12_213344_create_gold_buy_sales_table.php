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
        Schema::create('gold_buy_sales', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('purchase_memo');
            $table->string('cash_memo')->nullable();

            $table->decimal('exchange_gold_amount', 10, 2)->nullable();
            $table->string('exchange_gold_carat')->nullable();
            $table->decimal('exchange_gold_weight', 10, 2)->nullable();

            $table->decimal('customer_gold_amount', 10, 2)->nullable();
            $table->string('customer_gold_carat')->nullable();
            $table->decimal('customer_gold_weight', 10, 2)->nullable();

            $table->decimal('senco_amount', 10, 2)->nullable();
            $table->string('senco_carat')->nullable();
            $table->decimal('senco_weight', 10, 2)->nullable();

            $table->decimal('sales_return_amount', 10, 2)->nullable();
            $table->string('sales_return_carat')->nullable();
            $table->decimal('sales_return_weight', 10, 2)->nullable();

            $table->decimal('total_amount', 10, 2)->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('gold_buy_sales');
    }
};
