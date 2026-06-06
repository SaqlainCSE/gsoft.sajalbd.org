<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPaymentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment',
        'payment_info',
        'amount',
        'reference'
    ];
}
