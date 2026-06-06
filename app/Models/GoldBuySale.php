<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\Weibull;

class GoldBuySale extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'purchase_memo',
        'cash_memo',

        'exchange_gold_amount',
        'exchange_gold_carat',
        'exchange_gold_weight',

        'customer_gold_amount',
        'customer_gold_carat',
        'customer_gold_weight',

        'senco_amount',
        'senco_carat',
        'senco_weight',

        'sales_return_amount',
        'sales_return_carat',
        'sales_return_weight',

        'total_amount',
        'remarks',
    ];
}
