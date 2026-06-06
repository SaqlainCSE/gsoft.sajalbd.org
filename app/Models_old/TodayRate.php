<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TodayRate
 *
 * @property $id
 * @property $name
 * @property $rate
 * @property $is_active
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TodayRate extends Model
{
    
    static $rules = [
		'name' => 'required',
		'rate' => 'required',
		'is_active' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','rate','is_active'];



}
