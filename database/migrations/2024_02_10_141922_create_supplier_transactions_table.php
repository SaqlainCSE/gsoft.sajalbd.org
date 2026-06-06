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
        Schema::create('supplier_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no');
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->double('bill_amount')->nullable();
            $table->double('payment_amount')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_transactions');
    }
};
