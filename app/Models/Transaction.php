<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wildside\Userstamps\Userstamps;

/**
 * Class Transaction
 *
 * @property $id
 * @property $cash_memo_no
 * @property $client_id
 * @property $description
 * @property $bill_amount
 * @property $payment_amount
 * @property $created_at
 * @property $updated_at
 * @property $created_by
 * @property $updated_by
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Transaction extends Model
{

  use Userstamps;
  
  static $rules = [
    'cash_memo_no' => 'required',
    'client_id' => 'required',
    'bill_amount' => ['nullable', 'numeric'],
    'payment_amount' => ['nullable', 'numeric'],
    'advance' => ['nullable', 'numeric'],
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = [
    'cash_memo_no',
    'client_id',
    'description',
    'bill_amount',
    'payment_amount',
    'nullable',
    'advance'
  ];

  /**
   * Get the client that owns the Transaction
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }
}
