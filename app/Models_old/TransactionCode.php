<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TransactionCode
 *
 * @property $id
 * @property $name
 * @property $type
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TransactionCode extends Model
{
    use SoftDeletes;

    static $rules = [
		'name' => 'required',
		'type' => 'required',
		'is_active' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','type','is_active'];



}
