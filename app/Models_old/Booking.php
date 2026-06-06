<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Booking extends Model
{
    use HasFactory;
    use Userstamps;
    
    protected $fillable = [
        'client_id',
        'date',
        'vat',
        'discount',
        'paid',
        'bin_number',
        'booked_by'
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function bookedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'booked_by');
    }

    public function meta(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BookingMeta::class);
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(BookingPaymentInfo::class);
    }

    public static function boot()
    {
        parent::boot();
        /**
         * Write code on Method
         *
         * @return response()
         */
        static::creating(function ($item) {
            $item->bin_number =setting('bin');
        });
    }
}
