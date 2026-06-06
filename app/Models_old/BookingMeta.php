<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'product_id',
        'weight',
        'unit_price',
        'wage',
        'vat_amount',
        'total',
        'st_dia',
        'st_dia_price'
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
