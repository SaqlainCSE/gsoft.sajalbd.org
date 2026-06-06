<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

/**
 * Class Expense
 *
 * @property $id
 * @property $trx_head_id
 * @property $payment_method_id
 * @property $amount
 * @property $reference_no
 * @property $date
 * @property $note
 * @property $payment_info
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property $created_by
 * @property $updated_by
 * @property $deleted_by
 *
 * @property PaymentMethod $paymentMethod
 * @property TrxHead $trxHead
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Expense extends Model
{
    use SoftDeletes, Userstamps;

    static $rules = [
		'trx_head_id' => 'required|exists:trx_heads,id',
		'amount' => 'required|numeric',
		'date' => 'required|date',
        'payment_method_id' => 'required|exists:payment_methods,id',
        'reference_no' => 'nullable|string|max:255',
        'note' => 'nullable|string|max:255',
        'expense_by_id' => 'required|exists:users,id',
        'transaction_code_id' => 'required|exists:transaction_codes,id',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'trx_head_id',
        'payment_method_id',
        'amount',
        'reference_no',
        'date',
        'note',
        'payment_info',
        'expense_by_id',
        'transaction_code_id'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paymentMethod()
    {
        return $this->hasOne('App\Models\PaymentMethod', 'id', 'payment_method_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function trxHead()
    {
        return $this->hasOne('App\Models\TrxHead', 'id', 'trx_head_id');
    }
    
    /**
     * Get the expenseBy that owns the expense
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function expenseBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'expense_by_id');
    }

}
