<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

/**
 * Class TrxHead
 *
 * @property $id
 * @property $name
 * @property $type
 * @property $code
 * @property $description
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TrxHead extends Model
{
    use SoftDeletes;

    static $rules = [
      'name' => 'required',
      'type' => 'required',
      'is_active' => 'required',
      'transaction_code_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','type','transaction_code_id','description','is_active'];


    /**
     * Get the parent that owns the TrxHead
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TransactionCode::class, 'transaction_code_id', 'id');
    }
}
