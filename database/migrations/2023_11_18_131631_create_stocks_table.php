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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('memo')->nullable();
            $table->string('token')->nullable();
            $table->foreignId('client_id')->nullable();
            $table->double('unit_18k')->nullable();
            $table->double('unit_21k')->nullable();
            $table->double('unit_22k')->nullable();
            $table->double('st')->nullable();
            $table->double('d18k')->nullable();
            $table->double('dia')->nullable();
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
        Schema::dropIfExists('stocks');
    }
};
