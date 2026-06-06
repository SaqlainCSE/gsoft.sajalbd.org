<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockHasPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'memo',
        'bill_amount',
        'discount',
        'advance',
        'final_bill',
        'gold',
        'cash',
        'dbbl',
        'city_qr',
        'cbbl',
    ];
}
