<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerCategory
 *
 * @property $id
 * @property $name
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CustomerCategory extends Model
{
    
    static $rules = [
		'name' => 'required',
		'status' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','status'];



}
