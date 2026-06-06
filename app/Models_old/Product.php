<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 *
 * @property $id
 * @property $product_nr
 * @property $product_details
 * @property $weight
 * @property $price
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property $created_by
 * @property $updated_by
 * @property $deleted_by
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Product extends Model
{
  use SoftDeletes;

  static $rules = [
    'product_nr' => [
      'required',
      'unique:products'
    ],
    'product_details' => ['required', 'string'],
    'weight' => ['required', 'numeric'],
    'price' => ['nullable', 'numeric'],
    'wage' => ['nullable', 'numeric'],
    'wage_type' => ['required', 'in:Percentage,Fixed'],
    'st_dia' => ['nullable', 'numeric'],
    'type' => ['required', 'in:gold,diamond'],
    'carat' => ['required', 'in:18,21,22'],
    'product_category_id' => ['required', 'integer'],

    'supplier_id' => ['nullable', 'integer'],
    'purchase_price' => ['nullable', 'numeric'],
    'qty' => ['nullable', 'numeric'],
    'stock_type' => ['nullable', 'in:NEW STOCK,EXCHANGE,OLD GOLD,S. RETURN'],
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = [
    'product_nr',
    'product_details',
    'weight',
    'price',
    'wage',
    'wage_type',
    'status',
    'booking_number',
    'st_dia',
    'st_dia_price',
    'type',
    'carat',
    'product_category_id',
    'supplier_id',
    'purchase_price',
    'qty',
    'stock_type',
    'purchase_date',
  ];

protected $casts = [
    'purchase_date' => 'date',
];


  /**
   * Get the order_meta associated with the Product
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function order_meta(): HasOne
  {
    return $this->hasOne(OrderMeta::class);
  }

  /**
   * Get the user that owns the Product
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function category()
  {
    return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
  }

  /**
   * Get the supplier that owns the Product
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function supplier()
  {
      return $this->belongsTo(Supplier::class);
  }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'token', 'product_nr');
    }

}
