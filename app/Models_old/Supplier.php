<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 *
 * @property $id
 * @property $name
 * @property $mobile_number
 * @property $due_amount
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Supplier extends Model
{

  static $rules = [
    'name' => 'required',
    'mobile_number' => 'required',
    'due_amount' => ['nullable', 'numeric'],
  ];

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'mobile_number', 'due_amount'];



}
