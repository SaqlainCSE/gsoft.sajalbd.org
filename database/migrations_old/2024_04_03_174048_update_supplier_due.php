<?php

use App\Models\Supplier;
use App\Models\SupplierTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $suppliers = Supplier::query()->get();

        foreach ($suppliers as $supplier) {
            $bill_amount = SupplierTransaction::where('supplier_id', $supplier->id)
                ->sum('bill_amount');
            $payment_amount = SupplierTransaction::where('supplier_id', $supplier->id)
                ->sum('payment_amount');

            $supplier->due_amount = $bill_amount - $payment_amount;
            $supplier->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
