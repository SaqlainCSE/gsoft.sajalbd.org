<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductCategory
 *
 * @property $id
 * @property $name
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ProductCategory extends Model
{
    
    static $rules = [
		'name' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id', 'id');
    }



}
