<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Order extends Model
{
    use HasFactory;
    use Userstamps;

    protected $fillable = [
        'client_id',
        'cash_memo_no',
        'date',
        'vat',
        'discount',
        'paid',
        'sale_type_id',
        'bin_number',
        'return_amount',
        'sell_by'
    ];

    public function sellBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'sell_by');
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function saleType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SaleType::class);
    }

    public function meta(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderMeta::class);
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(OrderPaymentInfo::class);
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
