<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 *
 * @property $id
 * @property $name
 * @property $created_at
 * @property $updated_at
 * @property $status
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PaymentMethod extends Model
{

  static $rules = [
    'name' => 'required',
    'status' => 'required',
    'under_type' => 'required'
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'status', 'under_type'];
}
