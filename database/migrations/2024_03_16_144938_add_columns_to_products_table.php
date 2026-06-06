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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable();
            $table->double('purchase_price')->nullable();
            $table->double('qty')->nullable()->default(1);
            $table->enum('stock_type', ['NEW STOCK', 'EXCHANGE', 'OLD GOLD', 'S. RETURN'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('supplier_id');
            $table->dropColumn('purchase_price');
            $table->dropColumn('qty');
            $table->dropColumn('stock_type');
        });
    }
};
